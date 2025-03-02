<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use DB;
class TestController extends Controller {

    public function firstAction(){

        $localName = 'ahmed';
        $newBooks = ['php' , 'java' , 'css'];
        return view('test' , ['name' => $localName , 'books'=>$newBooks]);

    }

    public function list(Request $request) {
        $products = (object)[
        (object)['id'=>1, 'code'=>'TV01', 'name'=>'LG TV 50"',
        'model'=>'LG8768787', 'photo'=>'lgtv50.jpg',
        'description'=>'lorem ipsum..'],
        (object)['id'=>2, 'code'=>'RF01', 'name'=>'Toshiba Refrigerator 14"',
        'model'=>'TS76634', 'photo'=>'tsrf50.jpg',
        'description'=>'lorem ipsum..'],
        ];
        return view("products", compact('products'));
        }
    }