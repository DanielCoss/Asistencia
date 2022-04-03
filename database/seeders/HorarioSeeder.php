<?php

namespace Database\Seeders;

use App\Models\Horario;
use Illuminate\Database\Seeder;

class HorarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $h = new Horario();
       $h->clave = 293888;
       $h->hora = 1;
       $h->dia = 1;
       $h->clase = "Ingles 1";
       $h->salon = "1o B";
       $h->save();
       unset($h);

       $h = new Horario();
       $h->clave = 293888;
       $h->hora = 1;
       $h->dia = 2;
       $h->clase = "Ingles 2";
       $h->salon = "3o B";
       $h->save();
       unset($h);

       $h = new Horario();
       $h->clave = 293888;
       $h->hora = 1;
       $h->dia = 3;
       $h->clase = "Ingles 2";
       $h->salon = "3o B";
       $h->save();
       unset($h);

       $h = new Horario();
       $h->clave = 293888;
       $h->hora = 1;
       $h->dia = 4;
       $h->clase = "Ingles 1";
       $h->salon = "1o B";
       $h->save();
       unset($h);

       $h = new Horario();
       $h->clave = 293888;
       $h->hora = 1;
       $h->dia = 5;
       $h->clase = "Ingles 3";
       $h->salon = "3o B";
       $h->save();
       unset($h);

       $h = new Horario();
       $h->clave = 293888;
       $h->hora = 2;
       $h->dia = 1;
       $h->clase = "Ingles 3";
       $h->salon = "3o A";
       $h->save();
       unset($h);

       $h = new Horario();
       $h->clave = 293888;
       $h->hora = 2;
       $h->dia = 2;
       $h->clase = "Ingles 3";
       $h->salon = "3o A";
       $h->save();
       unset($h);

       $h = new Horario();
       $h->clave = 293888;
       $h->hora = 2;
       $h->dia = 4;
       $h->clase = "Ingles 1";
       $h->salon = "1o A";
       $h->save();
       unset($h);

       $h = new Horario();
       $h->clave = 293888;
       $h->hora = 2;
       $h->dia = 5;
       $h->clase = "Ingles 1";
       $h->salon = "1o B";
       $h->save();
       unset($h);

       $h = new Horario();
       $h->clave = 293888;
       $h->hora = 3;
       $h->dia = 2;
       $h->clase = "Ingles 1";
       $h->salon = "1o B";
       $h->save();
       unset($h);

       $h = new Horario();
       $h->clave = 293888;
       $h->hora = 3;
       $h->dia = 3;
       $h->clase = "Ingles 3";
       $h->salon = "3o B";
       $h->save();
       unset($h);

       $h = new Horario();
       $h->clave = 293888;
       $h->hora = 3;
       $h->dia = 4;
       $h->clase = "Ingles 1";
       $h->salon = "1o A";
       $h->save();
       unset($h);

       $h = new Horario();
       $h->clave = 293888;
       $h->hora = 4;
       $h->dia = 1;
       $h->clase = "Ingles 1";
       $h->salon = "1o c";
       $h->save();
       unset($h);

       $h = new Horario();
       $h->clave = 293888;
       $h->hora = 4;
       $h->dia = 4;
       $h->clase = "Ingles 3";
       $h->salon = "1o c";
       $h->save();
       unset($h);

       $h = new Horario();
       $h->clave = 293888;
       $h->hora = 4;
       $h->dia = 5;
       $h->clase = "Ingles 1";
       $h->salon = "3o A";
       $h->save();
       unset($h);
    }
}
