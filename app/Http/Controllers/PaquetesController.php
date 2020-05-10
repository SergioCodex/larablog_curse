<?php

namespace App\Http\Controllers;

use App\User;
use App\Charts\MyChart;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PaquetesController extends Controller
{
    public function charts()
    {

        $chart = new MyChart();

        $chart->my_chart();

        $chart->labels(['One', 'Two', 'Three', 'Four', 'Five']);

        $chart->dataset('My dataset 1', 'line', [1, 2, 3, 4, 2, 3, 4]);

        return view("paquetes.charts", ['chart' => $chart]);
    }

    public function image()
    {
        $img = Image::make('images/logo.png');
        $img->resize(200, 100, function ($constraint) {
            $constraint->aspectRatio();
        });

        //$img->insert('watermark.png');

        $img->save('thumbnail.png');
    }

    public function qr_generate()
    {
        return QrCode::format('png')->size(700)->color(255, 0, 0)->generate('Make me into a QrCode!', '../public/qrcodes/ejemplo.svg');
    }

    public function stripe_create_customer()
    {
        $user = User::find(1);
        $stripeCustomer = $user->createAsStripeCustomer();
        dd($stripeCustomer);
    }

    public function stripe_payment_method_register()
    {
        $user = User::find(1);
        return view('paquetes.stripe_payment_method_register', [
            'intent' => $user->createSetupIntent()
        ]);
    }

    public function stripe_payment_method_create()
    {
        $user = User::find(1);
        $user->addPaymentMethod('pm_1GhGcdBlWLGeI8ua5io4koe1');
    }

    public function stripe_payment_method()
    {
        $user = User::find(1);
        dd($user->paymentMethods());
    }

    public function stripe_create_only_pay_form()
    {
        $user = User::find(1);
        return view('paquetes.stripe_create_only_pay_form');
    }

    public function stripe_create_only_pay()
    {
        $user = User::find(1);
        $stripeCharge = $user->charge(100, "pm_1GhGmvBlWLGeI8uaBZQMxqCa");
        dd($stripeCharge);
    }

    public function stripe_subscription()
    {
        $user = User::find(1);
        $paymentMethod = $user->defaultPaymentMethod();
        $user->newSubscription('default', 'plan_HFmVKvbFinOtNO')->create($paymentMethod->id);
    }
}
