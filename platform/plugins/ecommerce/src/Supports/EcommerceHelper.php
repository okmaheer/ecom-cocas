<?php

namespace Botble\Ecommerce\Supports;

use Botble\Base\Supports\Helper;
use Exception;
use Illuminate\Http\Request;
use Botble\Ecommerce\Repositories\Interfaces\OrderProductImagesInterface;
use DB;

class EcommerceHelper
{
    /**
     * @return bool
     */
    public function isCartEnabled(): bool
    {
        return get_ecommerce_setting('shopping_cart_enabled', '1') == '1';
    }

    /**
     * @return bool
     */
    public function isReviewEnabled(): bool
    {
        return get_ecommerce_setting('review_enabled', '1') == '1';
    }

    /**
     * @return bool
     */
    public function isQuickBuyButtonEnabled(): bool
    {
        return get_ecommerce_setting('enable_quick_buy_button', '1') == '1';
    }

    /**
     * @return string
     */
    public function getQuickBuyButtonTarget(): string
    {
        return get_ecommerce_setting('quick_buy_target_page', 'checkout');
    }

    /**
     * @return bool
     */
    public function isZipCodeEnabled(): bool
    {
        return get_ecommerce_setting('zip_code_enabled', '0') == '1';
    }

    /**
     * @return bool
     */
    public function isDisplayProductIncludingTaxes(): bool
    {
        if (!$this->isTaxEnabled()) {
            return false;
        }

        return get_ecommerce_setting('display_product_price_including_taxes', '0') == '1';
    }

    /**
     * @return bool
     */
    public function isTaxEnabled(): bool
    {
        return get_ecommerce_setting('ecommerce_tax_enabled', '1') == '1';
    }

    /**
     * @return array
     */
    public function getAvailableCountries(): array
    {
        try {
            $selectedCountries = json_decode(get_ecommerce_setting('available_countries'), true);
        } catch (Exception $exception) {
            $selectedCountries = [];
        }

        if (empty($selectedCountries)) {
            return Helper::countries();
        }

        $countries = [];

        foreach (Helper::countries() as $key => $item) {
            if (in_array($key, $selectedCountries)) {
                $countries[$key] = $item;
            }
        }

        return $countries;
    }

    /**
     * @return array
     */
    public function getSortParams(): array
    {
        return [
            'default_sorting' => __('Default'),
            'date_asc'        => __('Oldest'),
            'date_desc'       => __('Newest'),
            'price_asc'       => __('Price: low to high'),
            'price_desc'      => __('Price: high to low'),
            'name_asc'        => __('Name: A-Z'),
            'name_desc'       => __('Name : Z-A'),
            'rating_asc'      => __('Rating: low to high'),
            'rating_desc'     => __('Rating: high to low'),
        ];
    }

    /**
     * @return array
     */
    public function getShowParams(): array
    {
        return [
            12    => 12,
            24    => 24,
            36    => 36,
        ];
    }

    /**
     * @return float
     */
    public function getMinimumOrderAmount()
    {
        return get_ecommerce_setting('minimum_order_amount', 0);
    }

    /**
     * @return bool
     */
    public function isEnabledGuestCheckout(): bool
    {
        return get_ecommerce_setting('enable_guest_checkout', '1') == '1';
    }

    /**
     * @return array
     */
    public function getDateRangeInReport(Request $request)
    {
        $startDate = now()->startOfMonth();
        $endDate = now();

        if ($request->get('date_from')) {
            try {
                $startDate = now()->createFromFormat('Y-m-d', $request->get('date_from'));
            } catch (Exception $ex) {
            }
            if (!$startDate) {
                $startDate = now()->startOfMonth();
            }
        }

        if ($request->get('date_to')) {
            try {
                $endDate = now()->createFromFormat('Y-m-d', $request->get('date_to'));
            } catch (Exception $ex) {
            }
            if (!$endDate) {
                $endDate = now();
            }
        }

        if ($endDate->gt(now())) {
            $endDate = now();
        }

        if ($startDate->gt($endDate)) {
            $startDate = now()->startOfMonth();
        }

        return [$startDate, $endDate];
    }

    public function get_order_single_image($order_id = NULL, $product_id = NULL, $image = NULL, $order_product_id = NULL){
       if(!empty($order_id) && !empty($product_id) && !empty($order_product_id)){
           $images = DB::table('ec_order_product_images')->where(array('order_id' => $order_id, 'product_id' => $product_id))->first();
           if(isset($images->crop_image) && !empty($images->crop_image)){
               $image = asset($images->crop_image);
           }
       }
       return $image;
   }

   public function count_order_images($order_id = NULL, $product_id = NULL, $totalImages = NULL){
      if(!empty($order_id) && !empty($product_id)){
          $totalImages = DB::table('ec_order_product_images')->where(array('order_id' => $order_id, 'product_id' => $product_id))->count();
      }
      return $totalImages;
  }
  public function get_order_images($order_id = NULL, $product_id = NULL, $order_product_id = NULL){
     $totalImages = array();
     if(!empty($order_id) && !empty($product_id) && !empty($order_product_id)){
         $totalImages = DB::table('ec_order_product_images')->where(array('order_id' => $order_id, 'product_id' => $product_id, 'order_product_id' => $order_product_id))->get();
     }
     return $totalImages;
 }

 public function sendSms($phone = NULL, $message = NULL){
     if(!empty($phone) && !empty($message) ){
         // Account details
		$apiKey = urlencode('NTkzOTVhNzc2MzcwNDc1NDZlMzU0NzcwNjUzMzY1NTQ=');
		// Message details
		$phone = substr($phone, -10);
		$numbers = array('91'.$phone);
		$sender = urlencode('600010');
		$message = rawurlencode($message);

		$numbers = implode(',', $numbers);

		// Prepare data for POST request
		$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
		// Send the POST request with cURL
		$ch = curl_init('https://api.textlocal.in/send/');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		// Process your response here
		echo $response;
     }
     return true;
 }


}
