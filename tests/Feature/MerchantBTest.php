<?php


use App\Models\Merchant;
use App\Models\Payment;
use App\Models\PaymentStatus;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class MerchantBTest extends TestCase
{
    protected int $merchantId = 816;
    protected int $paymentId = 73;
    protected string $statusName = "completed";
    protected array $merchantData;
    use LazilyRefreshDatabase;


    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->merchantData = [
            "project" => $this->merchantId,
            "invoice" => $this->paymentId,
            "status" => $this->statusName,
            "amount" => 700,
            "amount_paid" => 700,
            "rand" => "SNuHufEJ",
        ];
    }

    /**
     * A basic test example.
     */
    public function test_valid_signature_returns_successful_response_for_merchantB(): void
    {
        $paymentStatus = PaymentStatus::factory()->create([
            'title' => "created"
        ]);
        $merchant = Merchant::factory()->create([
            "merchant_id" => $this->merchantId
        ]);
        Payment::factory()->for($paymentStatus)->for($merchant)->create([
            "payment_id" => $this->paymentId
        ]);
        $response = $this->post('/callback_url/merchantB', $this->merchantData, [
            "authorization" => "d84eb9036bfc2fa7f46727f101c73c73"
        ]);
        $response->assertStatus(200); // everything was ok
        $updatedPayment = Payment::where('payment_id', $this->paymentId)->first();
        $this->assertEquals("paid", $updatedPayment->paymentStatus->title); // status changed
    }

    public function test_invalid_signature_returns_no_permissions_response_for_merchantB(): void
    {
        $paymentStatus = PaymentStatus::factory()->create([
            'title' => "created"
        ]);
        $merchant = Merchant::factory()->create([
            "merchant_id" => $this->merchantId
        ]);
        Payment::factory()->for($paymentStatus)->for($merchant)->create([
            "payment_id" => $this->paymentId
        ]);
        $invalidMerchantData = $this->merchantData;
        $invalidMerchantData["sign"] = "f027612e0e6cb321ca161de060237eeb97e46000da39d3add08d09074f93172";
        $response = $this->post('/callback_url/merchantB', $invalidMerchantData, [
            "authorization" => "d84eb9036bfc2fa7f46727f101c73c71"
        ]);
        $response->assertStatus(403); //invalid signature
        $updatedPayment = Payment::where('payment_id', $this->paymentId)->first();
        $this->assertNotEquals("paid", $updatedPayment->paymentStatus->title); //status not changed
    }

    public function test_not_existing_payment_with_incorrect_payment_id_returns_not_found_response_for_merchantB(): void
    {
        $differentPaymentId = 12;
        $paymentStatus = PaymentStatus::factory()->create([
            'title' => "created"
        ]);
        $merchant = Merchant::factory()->create([
            "merchant_id" => $this->merchantId
        ]);
        Payment::factory()->for($paymentStatus)->for($merchant)->create([
            "payment_id" => $differentPaymentId
        ]);
        $response = $this->post('/callback_url/merchantB', $this->merchantData, [
            "authorization" => "d84eb9036bfc2fa7f46727f101c73c73"
        ]);
        $response->assertStatus(404); //payment not found
        $updatedPayment = Payment::where('payment_id', $differentPaymentId)->first();
        $this->assertNotEquals("paid", $updatedPayment->paymentStatus->title);  //status not changed
    }

    public function test_not_existing_payment_with_incorrect_merchant_id_returns_not_found_response_for_merchantB(): void
    {
        $differentMerchantId = 12;
        $paymentStatus = PaymentStatus::factory()->create([
            'title' => "created"
        ]);
        $merchant = Merchant::factory()->create([
            "merchant_id" => $differentMerchantId
        ]);
        Payment::factory()->for($paymentStatus)->for($merchant)->create([
            "payment_id" => $this->paymentId
        ]);
        $response = $this->post('/callback_url/merchantB', $this->merchantData, [
            "authorization" => "d84eb9036bfc2fa7f46727f101c73c73"
        ]);
        $response->assertStatus(404); //payment not found
        $updatedPayment = Payment::where('payment_id', $this->paymentId)->first();
        $this->assertNotEquals("paid", $updatedPayment->paymentStatus->title);  //status not changed
    }

}
