<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $channels = Channel::all();
        return view('contact', compact('categories', 'channels'));
    }

    public function confirm(ContactRequest $request)
    {
        $contacts = $request->all();
        $contacts['image_file'] = $request->image_file->store('img', 'public');
        $category = Category::find($request->category_id);
        $channels = Channel::find($request->channel_ids);
        return view('confirm', compact('contacts', 'category', 'channels'));
    }

    public function store(ContactRequest $request)
    {
        if ($request->has('back')) {
            return redirect('/')->withInput();
        }

        $request['tell'] = $request->tel_1 . $request->tel_2 . $request->tel_3;
        $contact = Contact::create(
            $request->only([
                'category_id',
                'first_name',
                'last_name',
                'gender',
                'email',
                'tell',
                'address',
                'building',
                'detail',
                'image_file'
            ])
        );
        $contact->channels()->sync($request->channel_ids);
        return view('thanks');
    }

    public function admin()
    {
        $contacts = Contact::with('category')->paginate(7);
        $categories = Category::all();
        $csvData = Contact::all();
        return view('admin', compact('contacts', 'categories', 'csvData'));
    }

    public function search(Request $request)
    {
        if ($request->has('reset')) {
            return redirect('/admin')->withInput();
        }
        $query = Contact::query();

        $query = $this->getSearchQuery($request, $query);

        $contacts = $query->paginate(7);
        $csvData = $query->get();
        $categories = Category::all();
        return view('admin', compact('contacts', 'categories', 'csvData'));
    }
}
