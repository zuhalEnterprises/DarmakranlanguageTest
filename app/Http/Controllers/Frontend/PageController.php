<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PageController extends Controller {
	public function show( $slug ) {

		$validator = Validator::make( [ 'slug' => $slug ], [
			'slug' => 'required|exists:posts,link_rewrite'
		] );



		$post = Post::where('type','page')->where( 'link_rewrite', $slug )->where( 'active', 1 )->first();


		return view('frontend.page.show', compact( 'post' ) );
	}
	public function aboutus() {
		return view('frontend.page.aboutus_v2');
	}
}
