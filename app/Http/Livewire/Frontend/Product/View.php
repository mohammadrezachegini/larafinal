<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\Cart;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class View extends Component
{
    public $category, $product, $quantityCount =1 ;


    public function incrementQuantity()
    {
        if($this->quantityCount < 10){
            $this->quantityCount++;
        }
    }
    public function decrementQuantity()
    {
        if($this->quantityCount > 1){
            $this->quantityCount--;
        }
    }

    public function addToCart(int $productId)
    {
        if(Auth::check())
        {
            if($this->product->where('id',$productId)->where('status','0')->exists())
            {
                if(Cart::where('user_id',auth()->user()->id)->where('product_id', $productId)->exists()){
                    $this->dispatchBrowserEvent('message', [
                                        'text' => 'Product Already Added',
                                        'type' => 'warning',
                                        'status' => 200
                                    ]);
                }
                else {
                    if(Cart::where('user_id',auth()->user()->id)->where('product_id', $productId)->exists()){
                    Cart::create([
                                'user_id' => auth()->user()->id,
                                'product_id' => $productId,
                                'quantity' => $this->quantityCount
                            ]);

                            $this->emit('CartAddedUpdated');
                            $this->dispatchBrowserEvent('message', [
                                'text' => 'Product Added to Cart',
                                'type' => 'success',
                                'status' => 200
                            ]);
                        }
                        else{
                            if(Cart::where('user_id',auth()->user()->id)->where('product_id', $productId)->exists())
                            {
                            $this->dispatchBrowserEvent('message', [
                                'text' => 'Product Already Added',
                                'type' => 'warning',
                                'status' => 200
                            ]);
                            }
                            else
                            {
                                if($this->product->quantity > 0)
                                {
                                    if($this->product->quantity >= $this->quantityCount)
                                    {
                                        // Insert Product to Cart
                                        Cart::create([
                                            'user_id' => auth()->user()->id,
                                            'product_id' => $productId,
                                            'quantity' => $this->quantityCount
                                        ]);

                                        $this->emit('CartAddedUpdated');
                                        $this->dispatchBrowserEvent('message', [
                                            'text' => 'Product Added to Cart',
                                            'type' => 'success',
                                            'status' => 200
                                        ]);
                                    }
                                    else
                                    {
                                        $this->dispatchBrowserEvent('message', [
                                            'text' => 'Only '.$this->product->quantity.' Quantity Available',
                                            'type' => 'warning',
                                            'status' => 404
                                        ]);
                                    }
                                }
                                else
                                {
                                    $this->dispatchBrowserEvent('message', [
                                        'text' => 'Out of Stock',
                                        'type' => 'warning',
                                        'status' => 404
                                    ]);
                                }
                            }
                            //
                        }

                    }

            }
            else
            {
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Please Login to add to cart',
                    'type' => 'info',
                    'status' => 401
                ]);
            }
        }

        else
        {
            $this->dispatchBrowserEvent('message', [
                'text' => 'Please Login to add to cart',
                'type' => 'info',
                'status' => 401
            ]);
        }
    }

    public function mount($category, $product)
    {
        $this->category = $category;
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.frontend.product.view',[
            'category' => $this->category,
            'product' => $this->product
        ]);
    }
}
