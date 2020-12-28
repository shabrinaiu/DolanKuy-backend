<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RelasiListLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('list_locations', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->change();
            $table->foreign('category_id')->references('id')->on('category_locations')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        DB::table('list_locations')->insert(
            array(
                'name' => 'Pendakian Gunung Pundak via Puthuk Siwur',
                'category_id' => 1, 
                'address' => 'Jl. Mustofa Kamal Pasa, Dusun Mligi, Claket, Kec. Pacet, Mojokerto, Jawa Timur 65162',
                'description' => 'Gunung mungil yang terletak di Desa Claket, Kecamatan Pacet, ini menjadi gunung favorit bagi para pendaki. Memiliki ketinggian 1.585 mdpl, gunung ini memiliki jalur ke puncak yang cukup bersahabat. Sangat ideal bagi mereka yang ingin mencoba pendakian atau yang ingin sekadar merasakan sensasi trekking.',

                'image' => 'N/A',
                'contact' => '-',
                'latitude' => '-7.6793613',
                'longitude' => '112.5679376'
            )
        );


        DB::table('list_locations')->insert(
            array(
                'name' => 'Pos 1 Perijinan Pendakian Gunung Penanggungan',
                'category_id' => 1, 
                'address' => 'Jl. Tamiajeng, Tamiajeng, Kec. Trawas, Mojokerto, Jawa Timur 61375',
                'description' => 'Gunung Penanggungan terletak diantara dua Kabupaten yaitu Kabupaten Pasuruan dan Mojokerto. Gunung ini sering disebut sebagai miniatur semeru karena bentuk puncak yang hampir sama dan Gunung ini merupakan Gunung berapi yang sedang tidak aktif. Gunung Penanggungan memiliki ketinggian 1653 Mdpl.',

                'image' => 'N/A',
                'contact' => '+6281232152477',
                'latitude' => '-7.6467759',
                'longitude' => '112.6030629'
            )
        );

        DB::table('list_locations')->insert(
            array(
                'name' => 'Pos Pendakian Gunung Butak Via Panderman',
                'category_id' => 1, 
                'address' => 'Unnamed Road, Pesanggrahan, Kec. Batu, Kota Batu, Jawa Timur 65313',
                'description' => 'Gunung Butak adalah gunung stratovolcano yang terletak di Kabupaten Malang, Jawa Timur, Indonesia. Gunung Butak terletak berdekatan dengan Gunung Kawi. Tidak diketemukan catatan sejarah atas erupsi dari Gunung Butak sampai saat ini.',

                'image' => 'N/A',
                'contact' => '-',
                'latitude' => '-7.9099793',
                'longitude' => '112.4305196'
            )
        );


        DB::table('list_locations')->insert(
            array(
                'name' => 'Pos Pendakian Gunung Panderman',
                'category_id' => 1, 
                'address' => 'Unnamed Road, Pesanggrahan, Kec. Batu, Kota Batu, Jawa Timur 65313',
                'description' => 'Gunung Panderman adalah sebuah gunung di Kota Batu, Jawa Timur, Indonesia, dengan puncaknya Basundara yang berketinggian 2.045 mdpl.',

                'image' => 'N/A',
                'contact' => '-',
                'latitude' => '-7.9099793',
                'longitude' => '112.4305196'
            )
        );

        DB::table('list_locations')->insert(
            array(
                'name' => 'Pos Pendakian Gunung Arjuno Via Lawang',
                'category_id' => 1, 
                'address' => 'Unnamed Road, Gemuk Utara, Wonorejo, Kec. Lawang, Malang, Jawa Timur 65216',
                'description' => 'Gunung Arjuno adalah sebuah gunung berapi kerucut di Jawa Timur, Indonesia dengan ketinggian 3.339 m dpl. Gunung Arjuno secara administratif terletak di perbatasan Kota Batu, Kabupaten Malang, dan Kabupaten Pasuruan dan berada di bawah pengelolaan Taman Hutan Raya Raden Soerjo.',

                'image' => 'N/A',
                'contact' => '-',
                'latitude' => '-7.8086648',
                'longitude' => '112.6518348'
            )
        );

        DB::table('list_locations')->insert(
            array(
                'name' => 'Basecamp Gunung Semeru Via Ranu Pane',
                'category_id' => 1, 
                'address' => 'Ranupane Satu, Ranupani, Senduro, Kabupaten Lumajang, Jawa Timur 67361',
                'description' => 'Gunung Semeru atau Gunung Meru adalah sebuah gunung berapi kerucut di Jawa Timur, Indonesia. Gunung Semeru merupakan gunung tertinggi di Pulau Jawa, dengan puncaknya Mahameru, 3.676 meter dari permukaan laut.',

                'image' => 'N/A',
                'contact' => '-',
                'latitude' => '-8.0099498',
                'longitude' => '112.9439716'
            )
        );

        DB::table('list_locations')->insert(
            array(
                'name' => 'Mie ayam putra solo',
                'category_id' => 2, 
                'address' => 'Jl. Abdul Rahman No.96, Payan, Pabean, Kec. Sedati, Kabupaten Sidoarjo, Jawa Timur 61253',
                'description' => 'Warung Mie Ayam yang terletak di Kabupaten Sidoarjo',

                'image' => 'N/A',
                'contact' => '+6282332084220',
                'latitude' => '-7.3677355',
                'longitude' => '112.7557768'
            )
        );

        DB::table('list_locations')->insert(
            array(
                'name' => 'Bebek Goreng H.Slamet-Juanda',
                'category_id' => 2, 
                'address' => 'Jl. Raya Sedati Gede No.83, Gebang, Sedati Gede, Kec. Sedati, Kabupaten Sidoarjo, Jawa Timur 61253',
                'description' => 'Restoran Bebek H.Slamet Cabang Juanda',

                'image' => 'N/A',
                'contact' => '-',
                'latitude' => '-7.3789476',
                'longitude' => '112.7606815'
            )
        );

        DB::table('list_locations')->insert(
            array(
                'name' => 'AYAM BAKAR WONG SOLO',
                'category_id' => 2, 
                'address' => 'Jl. Letjen Suprapto No.71, Tropodo Wetan, Kepuhkiriman, Kec. Waru, Kabupaten Sidoarjo, Jawa Timur 61256',
                'description' => 'Restoran Ayam Bakar Khas Wong Solo',

                'image' => 'N/A',
                'contact' => '+628116533018',
                'latitude' => '-7.3580065',
                'longitude' => '112.7622972'
            )
        );

        DB::table('list_locations')->insert(
            array(
                'name' => 'Masjid Baitul Makmur Kepuhkiriman Waru Sidoarjo',
                'category_id' => 3, 
                'address' => 'Kepuh, Kepuhkiriman, Kec. Waru, Kabupaten Sidoarjo, Jawa Timur 61256',
                'description' => 'Salah satu Masjid yang terletak di Kabupaten Sidoarjo',

                'image' => 'N/A',
                'contact' => '',
                'latitude' => '-7.3557129',
                'longitude' => '112.7651822'
            )
        );

        DB::table('list_locations')->insert(
            array(
                'name' => 'Masjid Al Ihsan Tropodo Permai',
                'category_id' => 3, 
                'address' => 'Jl. Dempo, Panyunan, Kepuhkiriman, Kec. Waru, Kabupaten Sidoarjo, Jawa Timur 61256',
                'description' => 'Salah satu Masjid yang terletak di Kabupaten Sidoarjo',

                'image' => 'N/A',
                'contact' => '+62318675578',
                'latitude' => '-7.353949',
                'longitude' => '112.7628699'
            )
        );

        DB::table('list_locations')->insert(
            array(
                'name' => 'Masjid Nasional Al-Akbar Surabaya',
                'category_id' => 3, 
                'address' => 'Jl. Mesjid Agung Tim. No.1, Pagesangan, Kec. Jambangan, Kota SBY, Jawa Timur 60274',
                'description' => 'Masjid Nasional Al Akbar ialah masjid terbesar kedua di Indonesia yang berlokasi di Kota Surabaya, Jawa Timur setelah Masjid Istiqlal di Jakarta.',

                'image' => 'N/A',
                'contact' => '-',
                'latitude' => '-7.3366088',
                'longitude' => '112.7129919'
            )
        );

        DB::table('list_locations')->insert(
            array(
                'name' => 'Super Indo Mastrip',
                'category_id' => 4, 
                'address' => 'Jl. Raya Mastrip No.4, Kebraon, Kec. Karang Pilang, Kota SBY, Jawa Timur 60222',
                'description' => 'Salah satu market yang terletak di Kabupaten Sidoarjo',

                'image' => 'N/A',
                'contact' => '+62317063145',
                'latitude' => '-7.3365605',
                'longitude' => '112.6976709'
            )
        );

        DB::table('list_locations')->insert(
            array(
                'name' => 'Indomaret Delta Wedoro',
                'category_id' => 4, 
                'address' => 'Jl. Belahan Wedoro No.9, Belahan, Wedoro, Kec. Waru, Kabupaten Sidoarjo, Jawa Timur 61256',
                'description' => 'Salah satu market terbesar di Indonesia, memiliki cabang yang terletak di Kabupaten Sidoarjo',

                'image' => 'N/A',
                'contact' => '+62318537413',
                'latitude' => '-7.3560019',
                'longitude' => '112.7471352'
            )
        );

        DB::table('list_locations')->insert(
            array(
                'name' => 'Alfamart Ngingas',
                'category_id' => 4, 
                'address' => 'Jl. Delta Raya III No.9, Ngingas, Kec. Waru, Kab. Sidoarjo, Jawa Timur 61256',
                'description' => 'Salah satu market terbesar di Indonesia, memiliki cabang yang terletak di Kabupaten Sidoarjo',

                'image' => 'N/A',
                'contact' => '+621500959',
                'latitude' => '-7.3597661',
                'longitude' => '112.7457181'
            )
        );

        DB::table('list_locations')->insert(
            array(
                'name' => 'SPBU Pertamina - Pabean',
                'category_id' => 5, 
                'address' => 'Jl. Raya Pabean No.38 D, Dabean, Pabean, Kec. Sedati, Kabupaten Sidoarjo, Jawa Timur 61253',
                'description' => 'Salah satu cabang SPBU Pertamina yang terletak di Kabupaten Sidoarjo',

                'image' => 'N/A',
                'contact' => '-',
                'latitude' => '-7.3686896',
                'longitude' => '112.7287384'
            )
        );

        DB::table('list_locations')->insert(
            array(
                'name' => 'SPBU Pertamina - bypass juanda',
                'category_id' => 5, 
                'address' => 'Sedati Gede, Kec. Sedati, Kabupaten Sidoarjo, Jawa Timur 61253',
                'description' => 'Salah satu cabang SPBU Pertamina yang terletak di Kabupaten Sidoarjo',

                'image' => 'N/A',
                'contact' => '+621500000',
                'latitude' => '-7.3685166',
                'longitude' => '112.7287383'
            )
        );

        DB::table('list_locations')->insert(
            array(
                'name' => 'SPBU Pertamina - Tropodo',
                'category_id' => 5, 
                'address' => 'Jl. Raya Tropodo No.62, Tropodo Wetan, Tropodo, Kec. Waru, Kabupaten Sidoarjo, Jawa Timur 61256',
                'description' => 'Salah satu cabang SPBU Pertamina yang terletak di Kabupaten Sidoarjo',

                'image' => 'N/A',
                'contact' => '-',
                'latitude' => '-7.3683437',
                'longitude' => '112.7287382'
            )
        );



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
