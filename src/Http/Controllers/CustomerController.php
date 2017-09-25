<?php

namespace TomIrons\Accountant\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Return all customers.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $customers = $this->factory->customer->all()
            ->currentPage($request->get('page', 1))
            ->paginate($request->url(), $request->query());

        foreach ($customers as $customer) {
            $customer->card = collect($customer->sources->data)->first();
        }

        return view('accountant::customers.index', compact('customers'));
    }

    /**
     * Show information about a specific customer.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $customer = $this->factory->customer->retrieve($id);
        dump($this->factory->subscription->all([
            'customer' => $customer->id
        ]));
        $cards = collect($customer->sources->data);
        $subscriptions = collect($customer->subscriptions->data);

        return view('accountant::customers.show', compact('cards', 'customer', 'subscriptions'));
    }
}