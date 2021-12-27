<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Validator;

class BooksController extends Controller
{
    public $insertValidations = array(
        "uuid" => "required|min:2|max:4",
        "name" => "required|max:50",
        "authorName" => "required|max:30"
    );

    public $updateDelValidations = array(
        "id" => "required|integer"
    );

    function listBooks(){
        $book = Book::all();
        if(count($book)){
            return response()->json(["Response" => $book], 200);
        } else {
            return response()->json(["Response" => "Book details not found"], 200);
        }
    }

    function findBook($id){
        $validator = Validator::make(array("id" => $id), $this->updateDelValidations);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        } else {
            $book = Book::find($id);
            if($book){
                return response()->json(["Response" => $book], 200);
            } else {
                return response()->json(["Response" => "Book details not found"], 200);
            }
        }
    }

    function addBook(Request $request){
        $validator = Validator::make($request->all(), $this->insertValidations);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        } else {
            $book = new Book;
            $book->uuid = $request->uuid;
            $book->name = $request->name;
            $book->authorName = $request->authorName;
            $result = $book->save();
            if($result){
                return response()->json(["Response" => "Data saved successfully"], 200);
            } else {
                return response()->json(["Response" => "Data not saved"], 401);
            }
        }
    }

    function updateBook(Request $request){
        $validator = Validator::make($request->all(), array_merge($this->insertValidations, $this->updateDelValidations));
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        } else {
            $book = Book::find($request->id);
            if($book){
                $book->name = $request->name;
                $book->authorName = $request->authorName;
                $book->uuid = $request->uuid;
                $result = $book->save();
                if($result){
                    return response()->json(["Response" => "Data updated successfully"], 200);
                } else {
                    return response()->json(["Response" => "Data not updated"], 401);
                }
            } else {
                return response()->json(["Response" => "Data not updated, Record not found"], 200);
            }
        }
    }

    function deleteBook($id){
        $validator = Validator::make(array("id" => $id), $this->updateDelValidations);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        } else {
            $book = Book::find($id);
            if($book){
                $result = $book->delete();
                if($result){
                    return response()->json(["Response" => "Data deleted successfully"], 200);
                } else {
                    return response()->json(["Response" => "Data not deleted"], 401);
                }
            } else {
                return response()->json(["Response" => "Data not deleted, Record does not exist"], 200);
            }
        }
    }

}
