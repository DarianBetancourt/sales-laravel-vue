<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $address = new Address();
        $address->cep = 69025040;         //cep
        $address->state = 'AM';            //estado
        $address->city = 'Manaus';         //ciudade
        $address->neighborhood = 'Centro';  //bairro
        $address->street = 'Avenida Tarumã';//Logradouro
        $address->save();

        $address2 = new Address();
        $address2->cep = 69025035;         //cep
        $address2->state = 'AM';            //estado
        $address2->city = 'Manaus';         //ciudade
        $address2->neighborhood = 'Centro';  //bairro
        $address2->street = 'Rua Tarumã';//Logradouro
        $address2->save();

        $address3 = new Address();
        $address3->cep = 69025020;         //cep
        $address3->state = 'AM';            //estado
        $address3->city = 'Manaus';         //ciudade
        $address3->neighborhood = 'Centro';  //bairro
        $address3->street = 'Rua Japurá';//Logradouro
        $address3->save();

        $address4 = new Address();
        $address4->cep = 69025000;         //cep
        $address4->state = 'AM';            //estado
        $address4->city = 'Manaus';         //ciudade
        $address4->neighborhood = 'Centro';  //bairro
        $address4->street = 'Rua Comendador Clementino';//Logradouro
        $address4->save();

        $address5 = new Address();
        $address5->cep = 69025010;         //cep
        $address5->state = 'AM';            //estado
        $address5->city = 'Manaus';         //ciudade
        $address5->neighborhood = 'Centro';  //bairro
        $address5->street = 'Rua Ferreira Pena';//Logradouro
        $address5->save();

    }
}
