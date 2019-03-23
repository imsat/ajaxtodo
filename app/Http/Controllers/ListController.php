<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ListController extends Controller
{
        public function index()
        {
            $items = Item::paginate(5);
//            return response()->json($items);
            return view('list',compact('items'));
        }
        public function paginate()
        {
            $items = Item::paginate(5);
            return view('list-item')->with('items',$items)->render();
        }

        public function create(Request $request)
        {

        }
        public function store(Request $request)
        {
            $item = new Item();
            $item->item = $request->text;
            $item->save();
            return 'Done';
        }
        public function update(Request $request)
        {
//            return $request->all();
            $item = Item::find($request->id);
            $item->item = $request->text;
            $item->save();
            return 'Done';
        }
        public function search(Request $request)
        {
            $term = $request->term;
            $items = Item::where('item', 'LIKE', '%'.$term.'%')->get();
            if(count($items) == 0){
                $searchResult[] =  'No Item Found';
            }else{
                foreach($items as $item){
                    $searchResult[] = $item->item;
                }


            }
            return  $searchResult;
//            return
//                $availableTags = [
//            "ActionScript",
//            "AppleScript",
//            "Asp",
//            "BASIC",
//            "C",
//            "C++",
//            "Clojure",
//            "COBOL",
//            "ColdFusion",
//            "Erlang",
//            "Fortran",
//            "Groovy",
//            "Haskell",
//            "Java",
//            "JavaScript",
//            "Lisp",
//            "Perl",
//            "PHP",
//            "Python",
//            "Ruby",
//            "Scala",
//            "Scheme"
//        ];
        }
        public function destroy(Request $request)
        {
            Item::where('id',$request->id)->delete();
            return 'Done';
        }

}
