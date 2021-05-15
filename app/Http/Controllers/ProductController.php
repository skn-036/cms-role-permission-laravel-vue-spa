<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index() {
        $products = Product::orderBy('id', 'asc')->paginate(12);
        $viewAllIndex = $viewIndex = $editIndex = $deleteIndex = true;
        $msg = '';

        //if auth user does not have 'Products-all' permission
        if(Auth::user()->cannot('viewAll', Product::class)) {
            $viewAllIndex = false;
            $msg = 'You do not have permissions to view products page';
        }
        
        //if auth user do not have 'Products-view' permission
        if(Auth::user()->cannot('view', Product::class)) {
            $viewIndex = false;
        }

        //if auth user do not have 'Products-edit' permission
        if(Auth::user()->cannot('edit', Product::class)) {
            $editIndex = false;
        }

        //if auth user do not have 'Products-delete' permission
        if(Auth::user()->cannot('delete', Product::class)) {
            $deleteIndex = false;
        }

        return response()->Json([
            'viewAll_index' => $viewAllIndex,
            'view_index' => $viewIndex,
            'edit_index' => $editIndex,
            'delete_index' => $deleteIndex,
            'message' => $msg,
            'data' => $products,
        ]);
    }

    public function show($id) {
        $product = Product::findOrFail($id);
        $index = true;
        $msg = '';

        //if auth user do not have 'Products-view' permission
        if(Auth::user()->cannot('view', Product::class)) {
            $index = false;
            $msg = 'You do not have access to view product details';       
        }

        return response()->Json([
            'index' => $index,
            'message' => $msg,
            'data' => $product,            
        ]);
    }

    public function create() {
        $index = true;
        $msg = '';

        //if auth user do not have 'Products-create' permission
        if(Auth::user()->cannot('create', Product::class)) {
            $index = false;
            $msg = 'You do not have access to create new product';       
        }

        return response()->Json([
            'index' => $index,
            'message' => $msg,        
        ]);        
    }

    public function edit() {
        $index = true;
        $msg = '';

        //if auth user do not have 'Products-edit' permission
        if(Auth::user()->cannot('edit', Product::class)) {
            $index = false;
            $msg = 'You do not have access to edit product';       
        }

        return response()->Json([
            'index' => $index,
            'message' => $msg,         
        ]);
    }

    public function del() {
        $index = true;
        $msg = '';

        //if auth user do not have 'Products-delete' permission
        if(Auth::user()->cannot('delete', Product::class)) {
            $index = false;
            $msg = 'You do not have access to delete product';       
        }

        return response()->Json([
            'index' => $index,
            'message' => $msg,         
        ]);
    }
}
