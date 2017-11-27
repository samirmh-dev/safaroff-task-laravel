<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	//userleri bazadan cekir
    	$istifadeciler=User::select('id','name','isAdmin','email','created_at')->get()->toArray();
        return view('admin.istifadeciler',compact('istifadeciler'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
    	/*
    	 * update emeliyyati birce adminlik statusunun deyisdirilmesi ucun
    	 * nezerde tutulub
    	 *
    	 */

    	$data=$request->toArray();
        if($data['update']*1){
			//admin et
	        User::where('id','=',$id*1)->update([
	        	'isAdmin'=>1
	        ]);
        }else{
	        //istifadeci et
	        User::where('id','=',$id*1)->update([
		        'isAdmin'=>0
	        ]);
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	//useri silir
        User::find($id*1)->delete();
        return back();
    }
}
