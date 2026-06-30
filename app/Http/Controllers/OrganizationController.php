<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrganizationController extends Controller
{
    /**
     * Show the user's password settings page.
     */
    public function show(Request $request): Response
    {

//            return Inertia::render('Organization',[
//                'organization' => Organization::query()->where('id', $request->id)
//                    ->where(['user_id' => Auth::id()])
//                    ->first(),
//                'reviews' => Review::query()->where('organization_id', $request->id)->orderBy('review_date', 'desc')->paginate(50)
//            ]);

            return Inertia::render('Dashboard');


    }
}
