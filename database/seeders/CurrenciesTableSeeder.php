<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Throwable;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->truncate();

        foreach (self::currencies() as $currency) {
            try {
                $Currency = new Currency($currency);
                $Currency->saveOrFail();
            }
            catch(Throwable $e) {
                echo 'Error during currency seeding ' . json_encode($currency) . ', skipping' . PHP_EOL;
            }
        }
    }

    /**
     * Currencies data provider
     *
     * @return array
     */
    public static function currencies(): array
    {
        return [
            ['code' => 'AED', 'symbol' => '\u062f.\u0625;', 'name' => 'UAE dirham'],
            ['code' => 'AFN', 'symbol' => 'Afs', 'name' => 'Afghan afghani'],
            ['code' => 'ALL', 'symbol' => 'L', 'name' => 'Albanian lek'],
            ['code' => 'AMD', 'symbol' => 'AMD', 'name' => 'Armenian dram'],
            ['code' => 'ANG', 'symbol' => 'NA\u0192', 'name' => 'Netherlands Antillean gulden'],
            ['code' => 'AOA', 'symbol' => 'Kz', 'name' => 'Angolan kwanza'],
            ['code' => 'ARS', 'symbol' => '$', 'name' => 'Argentine peso'],
            ['code' => 'AUD', 'symbol' => '$', 'name' => 'Australian dollar'],
            ['code' => 'AWG', 'symbol' => '\u0192', 'name' => 'Aruban florin'],
            ['code' => 'AZN', 'symbol' => 'AZN', 'name' => 'Azerbaijani manat'],
            ['code' => 'BAM', 'symbol' => 'KM', 'name' => 'Bosnia and Herzegovina konvertibilna marka'],
            ['code' => 'BBD', 'symbol' => 'Bds$', 'name' => 'Barbadian dollar'],
            ['code' => 'BDT', 'symbol' => '\u09f3', 'name' => 'Bangladeshi taka'],
            ['code' => 'BGN', 'symbol' => 'BGN', 'name' => 'Bulgarian lev'],
            ['code' => 'BHD', 'symbol' => '.\u062f.\u0628', 'name' => 'Bahraini dinar'],
            ['code' => 'BIF', 'symbol' => 'FBu', 'name' => 'Burundi franc'],
            ['code' => 'BMD', 'symbol' => 'BD$', 'name' => 'Bermudian dollar'],
            ['code' => 'BND', 'symbol' => 'B$', 'name' => 'Brunei dollar'],
            ['code' => 'BOB', 'symbol' => 'Bs.', 'name' => 'Bolivian boliviano'],
            ['code' => 'BRL', 'symbol' => 'R$', 'name' => 'Brazilian real'],
            ['code' => 'BSD', 'symbol' => 'B$', 'name' => 'Bahamian dollar'],
            ['code' => 'BTN', 'symbol' => 'Nu.', 'name' => 'Bhutanese ngultrum'],
            ['code' => 'BWP', 'symbol' => 'P', 'name' => 'Botswana pula'],
            ['code' => 'BYR', 'symbol' => 'Br', 'name' => 'Belarusian ruble'],
            ['code' => 'BZD', 'symbol' => 'BZ$', 'name' => 'Belize dollar'],
            ['code' => 'CAD', 'symbol' => '$', 'name' => 'Canadian dollar'],
            ['code' => 'CDF', 'symbol' => 'F', 'name' => 'Congolese franc'],
            ['code' => 'CHF', 'symbol' => 'Fr.', 'name' => 'Swiss franc'],
            ['code' => 'CLP', 'symbol' => '$', 'name' => 'Chilean peso'],
            ['code' => 'CNY', 'symbol' => '\u00a5', 'name' => 'Chinese/Yuan renminbi'],
            ['code' => 'COP', 'symbol' => 'Col$', 'name' => 'Colombian peso'],
            ['code' => 'CRC', 'symbol' => '\u20a1', 'name' => 'Costa Rican colon'],
            ['code' => 'CUC', 'symbol' => '$', 'name' => 'Cuban peso'],
            ['code' => 'CVE', 'symbol' => 'Esc', 'name' => 'Cape Verdean escudo'],
            ['code' => 'CZK', 'symbol' => 'K\u010d', 'name' => 'Czech koruna'],
            ['code' => 'DJF', 'symbol' => 'Fdj', 'name' => 'Djiboutian franc'],
            ['code' => 'DKK', 'symbol' => 'Kr', 'name' => 'Danish krone'],
            ['code' => 'DOP', 'symbol' => 'RD$', 'name' => 'Dominican peso'],
            ['code' => 'DZD', 'symbol' => '\u062f.\u062c', 'name' => 'Algerian dinar'],
            ['code' => 'EEK', 'symbol' => 'KR', 'name' => 'Estonian kroon'],
            ['code' => 'EGP', 'symbol' => '\u00a3', 'name' => 'Egyptian pound'],
            ['code' => 'ERN', 'symbol' => 'Nfa', 'name' => 'Eritrean nakfa'],
            ['code' => 'ETB', 'symbol' => 'Br', 'name' => 'Ethiopian birr'],
            ['code' => 'EUR', 'symbol' => '\u20ac', 'name' => 'European Euro'],
            ['code' => 'FJD', 'symbol' => 'FJ$', 'name' => 'Fijian dollar'],
            ['code' => 'FKP', 'symbol' => '\u00a3', 'name' => 'Falkland Islands pound'],
            ['code' => 'GBP', 'symbol' => '\u00a3', 'name' => 'British pound'],
            ['code' => 'GEL', 'symbol' => 'GEL', 'name' => 'Georgian lari'],
            ['code' => 'GHS', 'symbol' => 'GH\u20b5', 'name' => 'Ghanaian cedi'],
            ['code' => 'GIP', 'symbol' => '\u00a3', 'name' => 'Gibraltar pound'],
            ['code' => 'GMD', 'symbol' => 'D', 'name' => 'Gambian dalasi'],
            ['code' => 'GNF', 'symbol' => 'FG', 'name' => 'Guinean franc'],
            ['code' => 'GQE', 'symbol' => 'CFA', 'name' => 'Central African CFA franc'],
            ['code' => 'GTQ', 'symbol' => 'Q', 'name' => 'Guatemalan quetzal'],
            ['code' => 'GYD', 'symbol' => 'GY$', 'name' => 'Guyanese dollar'],
            ['code' => 'HKD', 'symbol' => 'HK$', 'name' => 'Hong Kong dollar'],
            ['code' => 'HNL', 'symbol' => 'L', 'name' => 'Honduran lempira'],
            ['code' => 'HRK', 'symbol' => 'kn', 'name' => 'Croatian kuna'],
            ['code' => 'HTG', 'symbol' => 'G', 'name' => 'Haitian gourde'],
            ['code' => 'HUF', 'symbol' => 'Ft', 'name' => 'Hungarian forint'],
            ['code' => 'IDR', 'symbol' => 'Rp', 'name' => 'Indonesian rupiah'],
            ['code' => 'ILS', 'symbol' => '\u20aa', 'name' => 'Israeli new sheqel'],
            ['code' => 'INR', 'symbol' => '\u20B9', 'name' => 'Indian rupee'],
            ['code' => 'IQD', 'symbol' => '\u062f.\u0639', 'name' => 'Iraqi dinar'],
            ['code' => 'IRR', 'symbol' => 'IRR', 'name' => 'Iranian rial'],
            ['code' => 'ISK', 'symbol' => 'kr', 'name' => 'Icelandic kr\u00f3na'],
            ['code' => 'JMD', 'symbol' => 'J$', 'name' => 'Jamaican dollar'],
            ['code' => 'JOD', 'symbol' => 'JOD', 'name' => 'Jordanian dinar'],
            ['code' => 'JPY', 'symbol' => '\u00a5', 'name' => 'Japanese yen'],
            ['code' => 'KES', 'symbol' => 'KSh', 'name' => 'Kenyan shilling'],
            ['code' => 'KGS', 'symbol' => '\u0441\u043e\u043c', 'name' => 'Kyrgyzstani som'],
            ['code' => 'KHR', 'symbol' => '\u17db', 'name' => 'Cambodian riel'],
            ['code' => 'KMF', 'symbol' => 'KMF', 'name' => 'Comorian franc'],
            ['code' => 'KPW', 'symbol' => 'W', 'name' => 'North Korean won'],
            ['code' => 'KRW', 'symbol' => 'W', 'name' => 'South Korean won'],
            ['code' => 'KWD', 'symbol' => 'KWD', 'name' => 'Kuwaiti dinar'],
            ['code' => 'KYD', 'symbol' => 'KY$', 'name' => 'Cayman Islands dollar'],
            ['code' => 'KZT', 'symbol' => 'T', 'name' => 'Kazakhstani tenge'],
            ['code' => 'LAK', 'symbol' => 'KN', 'name' => 'Lao kip'],
            ['code' => 'LBP', 'symbol' => '\u00a3', 'name' => 'Lebanese lira'],
            ['code' => 'LKR', 'symbol' => 'Rs', 'name' => 'Sri Lankan rupee'],
            ['code' => 'LRD', 'symbol' => 'L$', 'name' => 'Liberian dollar'],
            ['code' => 'LSL', 'symbol' => 'M', 'name' => 'Lesotho loti'],
            ['code' => 'LTL', 'symbol' => 'Lt', 'name' => 'Lithuanian litas'],
            ['code' => 'LVL', 'symbol' => 'Ls', 'name' => 'Latvian lats'],
            ['code' => 'LYD', 'symbol' => 'LD', 'name' => 'Libyan dinar'],
            ['code' => 'MAD', 'symbol' => 'MAD', 'name' => 'Moroccan dirham'],
            ['code' => 'MDL', 'symbol' => 'MDL', 'name' => 'Moldovan leu'],
            ['code' => 'MGA', 'symbol' => 'FMG', 'name' => 'Malagasy ariary'],
            ['code' => 'MKD', 'symbol' => 'MKD', 'name' => 'Macedonian denar'],
            ['code' => 'MMK', 'symbol' => 'K', 'name' => 'Myanma kyat'],
            ['code' => 'MNT', 'symbol' => '\u20ae', 'name' => 'Mongolian tugrik'],
            ['code' => 'MOP', 'symbol' => 'P', 'name' => 'Macanese pataca'],
            ['code' => 'MRO', 'symbol' => 'UM', 'name' => 'Mauritanian ouguiya'],
            ['code' => 'MUR', 'symbol' => 'Rs', 'name' => 'Mauritian rupee'],
            ['code' => 'MVR', 'symbol' => 'Rf', 'name' => 'Maldivian rufiyaa'],
            ['code' => 'MWK', 'symbol' => 'MK', 'name' => 'Malawian kwacha'],
            ['code' => 'MXN', 'symbol' => '$', 'name' => 'Mexican peso'],
            ['code' => 'MYR', 'symbol' => 'RM', 'name' => 'Malaysian ringgit'],
            ['code' => 'MZM', 'symbol' => 'MTn', 'name' => 'Mozambican metical'],
            ['code' => 'NAD', 'symbol' => 'N$', 'name' => 'Namibian dollar'],
            ['code' => 'NGN', 'symbol' => '\u20a6', 'name' => 'Nigerian naira'],
            ['code' => 'NIO', 'symbol' => 'C$', 'name' => 'Nicaraguan c\u00f3rdoba'],
            ['code' => 'NOK', 'symbol' => 'kr', 'name' => 'Norwegian krone'],
            ['code' => 'NPR', 'symbol' => 'NRs', 'name' => 'Nepalese rupee'],
            ['code' => 'NZD', 'symbol' => 'NZ$', 'name' => 'New Zealand dollar'],
            ['code' => 'OMR', 'symbol' => 'OMR', 'name' => 'Omani rial'],
            ['code' => 'PAB', 'symbol' => 'B./', 'name' => 'Panamanian balboa'],
            ['code' => 'PEN', 'symbol' => 'S/.', 'name' => 'Peruvian nuevo sol'],
            ['code' => 'PGK', 'symbol' => 'K', 'name' => 'Papua New Guinean kina'],
            ['code' => 'PHP', 'symbol' => '\u20b1', 'name' => 'Philippine peso'],
            ['code' => 'PKR', 'symbol' => 'Rs.', 'name' => 'Pakistani rupee'],
            ['code' => 'PLN', 'symbol' => 'z\u0142', 'name' => 'Polish zloty'],
            ['code' => 'PYG', 'symbol' => '\u20b2', 'name' => 'Paraguayan guarani'],
            ['code' => 'QAR', 'symbol' => 'QR', 'name' => 'Qatari riyal'],
            ['code' => 'RON', 'symbol' => 'L', 'name' => 'Romanian leu'],
            ['code' => 'RSD', 'symbol' => 'din.', 'name' => 'Serbian dinar'],
            ['code' => 'RUB', 'symbol' => 'R', 'name' => 'Russian ruble'],
            ['code' => 'SAR', 'symbol' => 'SR', 'name' => 'Saudi riyal'],
            ['code' => 'SBD', 'symbol' => 'SI$', 'name' => 'Solomon Islands dollar'],
            ['code' => 'SCR', 'symbol' => 'SR', 'name' => 'Seychellois rupee'],
            ['code' => 'SDG', 'symbol' => 'SDG', 'name' => 'Sudanese pound'],
            ['code' => 'SEK', 'symbol' => 'kr', 'name' => 'Swedish krona'],
            ['code' => 'SGD', 'symbol' => 'S$', 'name' => 'Singapore dollar'],
            ['code' => 'SHP', 'symbol' => '\u00a3', 'name' => 'Saint Helena pound'],
            ['code' => 'SLL', 'symbol' => 'Le', 'name' => 'Sierra Leonean leone'],
            ['code' => 'SOS', 'symbol' => 'Sh.', 'name' => 'Somali shilling'],
            ['code' => 'SRD', 'symbol' => '$', 'name' => 'Surinamese dollar'],
            ['code' => 'SYP', 'symbol' => 'LS', 'name' => 'Syrian pound'],
            ['code' => 'SZL', 'symbol' => 'E', 'name' => 'Swazi lilangeni'],
            ['code' => 'THB', 'symbol' => '\u0e3f', 'name' => 'Thai baht'],
            ['code' => 'TJS', 'symbol' => 'TJS', 'name' => 'Tajikistani somoni'],
            ['code' => 'TMT', 'symbol' => 'm', 'name' => 'Turkmen manat'],
            ['code' => 'TND', 'symbol' => 'DT', 'name' => 'Tunisian dinar'],
            ['code' => 'TRY', 'symbol' => 'TRY', 'name' => 'Turkish new lira'],
            ['code' => 'TTD', 'symbol' => 'TT$', 'name' => 'Trinidad and Tobago dollar'],
            ['code' => 'TWD', 'symbol' => 'NT$', 'name' => 'New Taiwan dollar'],
            ['code' => 'TZS', 'symbol' => 'TZS', 'name' => 'Tanzanian shilling'],
            ['code' => 'UAH', 'symbol' => 'UAH', 'name' => 'Ukrainian hryvnia'],
            ['code' => 'UGX', 'symbol' => 'USh', 'name' => 'Ugandan shilling'],
            ['code' => 'USD', 'symbol' => 'US$', 'name' => 'United States dollar'],
            ['code' => 'UYU', 'symbol' => '$U', 'name' => 'Uruguayan peso'],
            ['code' => 'UZS', 'symbol' => 'UZS', 'name' => 'Uzbekistani som'],
            ['code' => 'VEB', 'symbol' => 'Bs', 'name' => 'Venezuelan bolivar'],
            ['code' => 'VND', 'symbol' => '\u20ab', 'name' => 'Vietnamese dong'],
            ['code' => 'VUV', 'symbol' => 'VT', 'name' => 'Vanuatu vatu'],
            ['code' => 'WST', 'symbol' => 'WS$', 'name' => 'Samoan tala'],
            ['code' => 'XAF', 'symbol' => 'CFA', 'name' => 'Central African CFA franc'],
            ['code' => 'XCD', 'symbol' => 'EC$', 'name' => 'East Caribbean dollar'],
            ['code' => 'XDR', 'symbol' => 'SDR', 'name' => 'Special Drawing Rights'],
            ['code' => 'XOF', 'symbol' => 'CFA', 'name' => 'West African CFA franc'],
            ['code' => 'XPF', 'symbol' => 'F', 'name' => 'CFP franc'],
            ['code' => 'YER', 'symbol' => 'YER', 'name' => 'Yemeni rial'],
            ['code' => 'ZAR', 'symbol' => 'R', 'name' => 'South African rand'],
            ['code' => 'ZMK', 'symbol' => 'ZK', 'name' => 'Zambian kwacha'],
            ['code' => 'ZWR', 'symbol' => 'Z$', 'name' => 'Zimbabwean dollar']
        ];
    }
}
