<?php

namespace App\Http\Controllers\Api;

use App\helper\jdf;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Verta;

class CommentController extends Controller {
	public function store( Request $request, $user ) {
		$validator = Validator::make( $request->all(), [
			'product_id' => 'required|exists:products,id,deleted_at,NULL',
			'parent_id'  => 'nullable|exists:comments,id,deleted_at,NULL',
			'body'       => 'required|max:4000',
			'rate'       => 'required|between:1,5',
		] );

		if ( $validator->fails() ) {
            return badRequest( $validator->errors() );
		}

		$parent_id = ! empty( $request->parent_id ) ? $request->parent_id : null;
		$comment   = Comment::create( [
			'commentable_type' => 'product',
			'commentable_id'   => $request->product_id,
			'body'             => $request->body,
			'rate'             => $request->rate,
			'user_id'          => $user->id,
			'parent_id'        => $parent_id
		] );

		return response( [
			'status' => 'ok',
			'result' => 'دیدگاه شما ارسال شد، پس از بازبینی توسط مدیریت منتشر خواهد شد.'
		], config( 'StatusCode.SUCCESS' ) );
	}
}
