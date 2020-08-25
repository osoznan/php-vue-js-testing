<?php
/**
 * User: Zemlyansky Alexander <astrolog@online.ua>
 */

namespace app\site\models;

use osoznan\patri\Model;

class Acquire extends Model {

    public static function attributes() {
        return ['phone', 'name', 'description', 'time'];
    }

    public function rules() {
        return [
            [['phone', 'name', 'description'], 'required'],
            ['phone', 'str', 'min' => 10],
            ['name', 'str', 'min' => 2],
            ['phone', 'str', 'max' => 15],
            ['description', 'str', 'min' => 200]
        ];
    }

    public static function labels() {
        return [
            'name' => 'Имя',
            'phone' => 'Телефон',
            'description' => 'Описание',
            'time' => 'Время обращения'
        ];
    }

    public static function tableName() {
        return 'acquire';
    }
}
