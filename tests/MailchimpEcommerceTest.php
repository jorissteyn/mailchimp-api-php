<?php

namespace Mailchimp\Tests;

class MailchimpEcommerceTest extends \PHPUnit_Framework_TestCase {

  /**
   * Tests library functionality for stores information.
   */
  public function testGetStores() {
    $mc = new MailchimpEcommerce();
    $mc->getStores();

    $this->assertEquals('GET', $mc->getClient()->method);
    $this->assertEquals($mc->getEndpoint() . '/ecommerce/stores', $mc->getClient()->uri);
  }

  /**
   * Tests library functionality for store information.
   */
  public function testGetStore() {
    $store_id = 'MC002';

    $mc = new MailchimpEcommerce();
    $mc->getStore($store_id);

    $this->assertEquals('GET', $mc->getClient()->method);
    $this->assertEquals($mc->getEndpoint() . '/ecommerce/store/' . $store_id, $mc->getClient()->uri);
  }

  /**
   * Tests library function for adding a new store.
   */
  public function testAddStore() {
    $id = 'MC001';
    $list_id = '205d96e6b4';
    $name = "Freddie'\''s Merchandise";
    $currency_code = 'USD';

    $mc = new MailchimpEcommerce();
    $mc->addStore($id, $list_id, $name, $currency_code);

    $this->assertEquals('POST', $mc->getClient()->method);
    $this->assertEquals($mc->getEndpoint() . '/ecommerce/stores', $mc->getClient()->uri);

    $this->assertNotEmpty($mc->getClient()->options['json']);

    $request_body = $mc->getClient()->options['json'];

    $this->assertEquals($id, $request_body->id);
    $this->assertEquals($list_id, $request_body->list_id);
    $this->assertEquals($name, $request_body->name);
    $this->assertEquals($currency_code, $request_body->currency_code);
  }

  /**
   * Tests library functionality for updating a store.
   */
   public function testUpdateStore() {
     $store_id = 'MC001';
     $list_id = '205d96e6b4';
     $name = "Freddie'\''s Merchandise";
     $currency_code = 'USD';

     $mc = new MailchimpEcommerce();
     $mc->updateStore($store_id, $list_id, $name, $currency_code);

     $this->assertEquals('PATCH', $mc->getClient()->method);
     $this->assertEquals($mc->getEndpoint() . '/ecommerce/stores/' . $store_id, $mc->getClient()->uri);

     $this->assertNotEmpty($mc->getClient()->options['json']);

     $request_body = $mc->getClient()->options['json'];

     $this->assertEquals($list_id, $request_body->list_id);
     $this->assertEquals($name, $request_body->name);
     $this->assertEquals($currency_code, $request_body->currency_code);
   }

   /**
    * Tests library functionality for deleting stores.
    */
    public function testDelete() {
      $store_id = 'MC002';

      $mc = new MailchimpEcommerce();
      $mc->delete($store_id);

      $this->assertEquals('DELETE', $mc->getClient()->method);
      $this->assertEquals($mc->getEndpoint() . '/ecommerce/stores/' . $store_id, $mc->getClient()->uri);
    }

    /**
     * Tests library functionality for getting information on a store's carts.
     */
     public function testGetCarts() {
       $store_id = 'MC001';

       $mc = new MailchimpEcommerce();
       $mc->getCarts($store_id);

       $this->assertEquals('GET', $mc->getClient()->method);
       $this->assertEquals($mc->getEndpoint() . '/ecommerce/stores/' . $store_id . '/carts', $mc->getClient()->uri);
     }

     /**
      * Tests library functionality for getting information on a specific cart.
      */
      public function testGetCart() {
        $store_id = 'MC001';
        $cart_id = 'cart0001';

        $mc = new MailchimpEcommerce();
        $mc->getCart($store_id, $cart_id);

        $this->assertEquals('GET', $mc->getClient()->method);
        $this->assertEquals($mc->getEndpoint() . '/ecommerce/stores/' . $store_id . '/carts/' . $cart_id, $mc->getClient()->uri);
      }

      /**
       * Tests library function for adding a new cart.
       */
       public function testAddCart() {
         $store_id = 'MC001';
         $id = 'cart0001';
         $customer = (object) array(
           'id' => 'cust0005',
           'email_address' => 'freddy@freddiesjokes.com',
           'opt_in_status' => TRUE,
         );
         $currency_code = 'USD';
         $order_total = 12.45;

         $mc = new MailchimpEcommerce();
         $mc->addCart($store_id, $id, $customer, $currency_code, $order_total);

         $this->assertEquals('POST', $mc->getClient()->method);
         $this->assertEquals($mc->getEndpoint() . '/ecommerce/stores/' . $store_id . '/carts', $mc->getClient()->uri);

         $this->assertNotEmpty($mc->getClient()->options['json']);

         $request_body = $mc->getClient()->options['json'];

         $this->assertEquals($id, $request_body->id);
         $this->assertEquals($customer->id, $request_body->customer->id);
         $this->assertEquals($customer->email_address, $request_body->customer->email_address);
         $this->assertEquals($customer->opt_in_status, $request_body->customer->opt_in_status);
         $this->assertEquals($currency_code, $request_body->currency_code);
         $this->assertEquals($order_total, $request_body->order_total);
       }
}
