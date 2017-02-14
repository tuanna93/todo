<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(){
        $items = Item::get();
        return view('todo',compact('items'));
    }
    public function addItem($title){
        $item = new Item();
        $item->title = $title;
        $item->save();
        return $item->id;
    }
    public function deleteItem($id){
        $item = Item::find($id);
        $item->delete();
    }
}
