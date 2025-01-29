<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request){

        // jika ada params dengan category tertentu
        if($request->query('category')){
            $category = $request->query('category');
            $items = Item::where('category_id', $category)->get();
            return ItemResource::collection($items);
        }

        $items = Item::all();
        return ItemResource::collection($items);
    }

    public function show(Request $request){
        $item = Item::findOrFail($request['id']);
        return new ItemResource($item);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:225',
            'price' => 'required|numeric|integer',
            'image' => 'nullable|mimes:png,jpg,jpeg,jfif,webp|max:2048',
            'category_id' => 'required|integer|exists:categorys,id'
        ]);

        // value default dari image
        $newFileName = null;

        // jika ada image yang di upload
        if($request->file('image')){
            // file name awal
            $fileName = $request->file('image')->getClientOriginalName();
            // modified and add timestamp to file name
            $newFileName = strtolower(str_replace(' ', '_', Carbon::now()->format('Y_m_H_i_s') . '_' . $fileName));
            // simpan ke storage public di folde image dengan nama baru (image/$newFileName)
            $request->file('image')->storeAs('images', $newFileName);
        }

        // store ke database
        $result = Item::create([
            'name' => $request['name'],
            'price' => $request['price'],
            'image' => $newFileName,
            'category_id' => $request['category_id'],
        ]);

        // return hasil
        return response([
           'message' => 'success create new item',
           'data' => $result,
        ]);
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'nullable|max:225',
            'price' => 'nullable|numeric|integer',
            'image' => 'nullable|mimes:png,jpg,jpeg,jfif,webp|max:2048',
            'category_id' => 'nullable|integer|exists:categorys,id'
        ]);

        // data dari user
        $data = $request->only(['name', 'price', 'image']);

        // jika ada gambar
        if($request->file('image')){
            $fileName = $request->file('image')->getClientOriginalName();
            $newFileName = strtolower(str_replace(' ', '_', Carbon::now()->format('Y_m_H_i_s') . '_' . $fileName));
            $request->file('image')->storeAs('images', $newFileName);

            // masukan image ke data
            $data['image'] = $newFileName;
        }

        // cari id tertentu lalu update
        $result = Item::findOrFail($request['id']);
        $result->update($data);

        //return
        return response([
           'message' => 'success update item',
           'data' => $result,
        ]);
    }
}