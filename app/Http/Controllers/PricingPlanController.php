<?php

namespace App\Http\Controllers;

use App\Models\PricingPlan;
use Illuminate\Http\Request;

class PricingPlanController extends Controller
{
    public function index()
    {
        $plans = PricingPlan::orderBy('sort_order')->get();

        return view('pricing-plans.index', compact('plans'));
    }

    public function create()
    {
        return view('pricing-plans.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_popular'] = $request->boolean('is_popular');
        $validated['sort_order'] = (PricingPlan::max('sort_order') ?? 0) + 1;

        PricingPlan::create($validated);

        return redirect()->route('pricing-plans.index')->with('status', 'Pricing plan created.');
    }

    public function edit(PricingPlan $pricingPlan)
    {
        return view('pricing-plans.edit', ['plan' => $pricingPlan]);
    }

    public function update(Request $request, PricingPlan $pricingPlan)
    {
        $validated = $this->validated($request);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_popular'] = $request->boolean('is_popular');

        $pricingPlan->update($validated);

        return redirect()->route('pricing-plans.index')->with('status', 'Pricing plan updated.');
    }

    public function destroy(PricingPlan $pricingPlan)
    {
        $pricingPlan->delete();

        return response()->json(['message' => 'Pricing plan deleted.']);
    }

    public function toggleActive(PricingPlan $pricingPlan)
    {
        $pricingPlan->update(['is_active' => ! $pricingPlan->is_active]);

        return response()->json([
            'message'   => $pricingPlan->is_active ? 'Plan activated.' : 'Plan deactivated.',
            'is_active' => $pricingPlan->is_active,
        ]);
    }

    public function togglePopular(PricingPlan $pricingPlan)
    {
        $pricingPlan->update(['is_popular' => ! $pricingPlan->is_popular]);

        return response()->json([
            'message'    => $pricingPlan->is_popular ? 'Marked as Popular.' : 'Unmarked as Popular.',
            'is_popular' => $pricingPlan->is_popular,
        ]);
    }

    /**
     * AJAX: persist new drag-and-drop order.
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'order'   => ['required', 'array'],
            'order.*' => ['integer', 'exists:pricing_plans,id'],
        ]);

        foreach ($validated['order'] as $index => $id) {
            PricingPlan::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['message' => 'Order updated.']);
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'title'         => ['required', 'string', 'max:100'],
            'subtitle'      => ['nullable', 'string', 'max:100'],
            'price_monthly' => ['required', 'numeric', 'min:0'],
            'price_yearly'  => ['nullable', 'numeric', 'min:0'],
            'features'      => ['nullable', 'string'],
            'button_text'   => ['nullable', 'string', 'max:50'],
            'button_link'   => ['nullable', 'string', 'max:255'],
        ]);
    }
}
