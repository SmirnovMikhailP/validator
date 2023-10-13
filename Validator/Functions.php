<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

const PHONE_REGEX = '/^\s?(\+\s?7|8)([- ()]*\d){10}$/';

use Symfony\Component\HttpFoundation\JsonResponse;
use \http\Exception\InvalidArgumentException;

function checkPostFields()
{
    foreach ($_POST as $field) {
        try {
            if (empty($field)) {
                throw new InvalidArgumentException('Не введено одно из обязательных полей');
            }
        } catch (InvalidArgumentException $e) {
            return JsonResponse::create(['ok' => false, 'message' => $e->getMessage()], 400);
        }
    }
}

function validatePhone(string $phone)
{
    try {
        if (!preg_match(PHONE_REGEX, $phone)) {
            throw new InvalidArgumentException('Телефон введён неверно');
        }
    } catch (InvalidArgumentException $e) {
        return JsonResponse::create(['ok' => false, 'message' => $e->getMessage()], 400);
    }
}

function validateEmail(string $email)
{
    try {
        if  (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email введён неверно');
        }
    } catch (InvalidArgumentException $e) {
        return JsonResponse::create(['ok' => false, 'message' => $e->getMessage()], 400);
    }
}
