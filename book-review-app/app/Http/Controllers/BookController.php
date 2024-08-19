<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

use App\Http\Controllers\Controller;


class BookController extends Controller
{
    //this method will show books listing page
    public function index(){
        $books = Book::orderBy('created_at', 'DESC')->paginate(3);
        return view ('books.list' , [
        'books' => $books ]);
    }
    
    //this method will show create book page
    public function create(){
        return view ('books.create');

    }

    //this method will store a book in database
    public function store(Request $request){

        $rules = [
            'title' => 'required|min:5',
            'author' => 'required|min:3',
            'status' => 'required',
        ];
        
         if(!empty($request->image)){
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);
  
        if ($validator->fails()){
        return redirect()->route('books.create')->withInput()->withErrors($validator);

    }
    //save book in db;
    $book = new Book();
    $book->title = $request->title;
    $book->author = $request->author;
    $book->description = $request->description;
    $book->status = $request->status;
    $book->save();

    //upload book image

    if(!empty($request->image)){
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $imageName = time().'.'.$ext;
        $image->move(public_path('uploads/books'), $imageName);

        $book->image = $request->imageName;
        $book->save();

        

    }
    
    return redirect()->route('books.index')->with('success', 'Book added successfully.');

}

    //this method will show edit book page
    public function edit(){

    }

    //this method will update a book
    public function update(){

    }

    //this method will delete a book from database
    public function destroy(){

    }
}
