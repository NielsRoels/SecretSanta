<?php

namespace Intracto\SecretSantaBundle\Query;

class MandrillQuery
{
    private $mandrillApiKey;

    /**
     * @param $mandrillApiKey
     */
    public function __construct($mandrillApiKey)
    {
        $this->mandrillApiKey = $mandrillApiKey;
    }

    /**
     * @return array
     *
     * @throws \Mandrill_Error
     */
    public function getMandrillReport()
    {
        try {
            $mandrill = new \Mandrill($this->mandrillApiKey);
            $result = $mandrill->users->info();

            $mails_sent = $result['stats']['last_90_days']['sent'];
            $mails_opened = $result['stats']['last_90_days']['opens'];
            $unique_opens = $result['stats']['last_90_days']['unique_opens'];

            return [
                'mails_sent' => $mails_sent,
                'mails_opened' => $mails_opened,
                'unique_opens' => $unique_opens,
            ];
        } catch (\Mandrill_Error $e) {
            echo 'A Mandrill error occured: '.get_class($e).'-'.$e->getMessage();
            throw $e;
        }
    }
}
