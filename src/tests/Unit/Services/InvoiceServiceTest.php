<?php

namespace Tests\Unit\Services;

use App\Services\EmailService;
use App\Services\InvoiceService;
use App\Services\PaymentGatewayService;
use App\Services\SalesTaxService;
use PHPUnit\Framework\TestCase;

class InvoiceServiceTest extends TestCase
{



    public function testProcessInvoice():void
    {
        //create test doubles, by default they will return null
        $salesTaxService = $this->createMock(SalesTaxService::class);
        $gatewayService = $this->createMock(PaymentGatewayService::class);
        $emailService = $this->createMock(EmailService::class);


        //configure test doubles using method stubs
        $salesTaxService->method('calculate')->willReturn(10.0);
        $gatewayService->method('charge')->willReturn(true);
        $emailService->method('send')->willReturn(true);

        //success case: should return true
        //given invoice service
        $invoiceService = new InvoiceService($salesTaxService, $gatewayService, $emailService);

        $customer=['name'=>'ahmed'];
        $amount=100;

        //when process invoice
        $result = $invoiceService->process($customer, $amount);

        //then assert invoice is processed successfully
        $this->assertTrue($result);
    }

    public function testEmailSend():void
    {
        //create test doubles, by default they will return null
        $salesTaxService = $this->createMock(SalesTaxService::class);
        $gatewayService = $this->createMock(PaymentGatewayService::class);
        $emailService = $this->createMock(EmailService::class);


        //configure test doubles using method stubs
        $salesTaxService->method('calculate')->willReturn(10.0);
        $gatewayService->method('charge')->willReturn(true);


        //how we assert that the email is sent, mock what the emails expect as input and see
        $emailService->expects($this->once())->method('send')->with($this->equalTo(['name'=>'ahmed']),'receipt');


        $invoiceService = new InvoiceService($salesTaxService, $gatewayService, $emailService);

        $customer=['name'=>'ahmed'];
        $amount=100;

        //when process invoice
        $result = $invoiceService->process($customer, $amount);

        //then assert invoice is processed successfully
        $this->assertTrue($result);

    }

}