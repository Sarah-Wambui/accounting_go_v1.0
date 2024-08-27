<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferralComissionEmailTemplate extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('email_templates')->insert([
            [
                "name"                => "Referral Commission",
                "slug"                => "REFERRAL_COMISSION",
                "subject"             => "Congratulations! You've Earned a Referral Commission",
                "email_body"          => "<p>Dear {{name}},</p> <p>I hope this email finds you well.</p> <p>We are thrilled to inform you that you have successfully earned a referral commission through our program! We deeply appreciate your support and your help in spreading the word about our Dot Accounts Soultion.</p> <h3>Commission Details:</h3> <ul> <li><strong>Referral Name:</strong> {{ReferredUserName}}</li> <li><strong>Date of Referral:</strong> {{ReferredDate}}</li> <li><strong>Commission Amount:</strong> {{commissionAmount}}</li> </ul> <p>We are always looking to improve our services and the experience we provide. If you have any feedback or suggestions, we would love to hear from you.</p>",
                "sms_body"            => "",
                "notification_body"   => "",
                "shortcode"           => "{{name}} {{ReferredUserName}} {{ReferredDate}} {{commissionAmount}}",
                "email_status"        => 0,
                "sms_status"          => 0,
                "notification_status" => 0,
                "template_mode"       => 1,
            ],
            [
                "name"                => "Approve Referral Payout",
                "slug"                => "REFERRAL_PAYOUT_APPROVED",
                "subject"             => "Your Payout Request has been approved",
                "email_body"          => "<p>Dear <strong>{{name}}</strong>,</p> <p>We are pleased to inform you that a payout of <strong>{{amount}}</strong> has been successfully processed via your nominated payment method.</p> <p><strong>Details of the Transaction:</strong></p> <ul> <li><strong>Payout Amount:</strong> {{amount}}</li> <li><strong>Transaction Date:</strong> {{date}}</li> <li><strong>Payment Method:</strong> {{paymentMethod}}</li></ul><p>Thank you for your continued trust and cooperation.</p>",
                "sms_body"            => "",
                "notification_body"   => "",
                "shortcode"           => "{{name}} {{amount}} {{date}} {{paymentMethod}}",
                "email_status"        => 0,
                "sms_status"          => 0,
                "notification_status" => 0,
                "template_mode"       => 1,
            ],
            [
                "name"                => "Reject Referral Payout",
                "slug"                => "REFERRAL_PAYOUT_REJECTED",
                "subject"             => "Your Payout Request has been rejected",
                "email_body"          => "<p>Dear <strong>{{name}}</strong>,</p> <p>We regret to inform you that your payment request for the amount of <strong>{{amount}}</strong>, submitted on <strong>{{requestDate}}</strong>, has been rejected.</p> <p><strong>Reason for Rejection:</strong></p> <p>{{rejectionReason}}</p> <p>We apologize for any inconvenience this may have caused and appreciate your understanding.</p>",
                "sms_body"            => "",
                "notification_body"   => "",
                "shortcode"           => "{{name}} {{amount}} {{requestDate}} {{rejectionReason}}",
                "email_status"        => 0,
                "sms_status"          => 0,
                "notification_status" => 0,
                "template_mode"       => 1,
            ],
        ]);
    }
}
