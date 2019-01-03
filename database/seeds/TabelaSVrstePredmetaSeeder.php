<?php

use Illuminate\Database\Seeder;

class TabelaSVrstePredmetaSeeder extends Seeder
{

    public function run()
    {
        DB::beginTransaction();
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Експропријација', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Ујед пса - Нематеријална штета-', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Пад на улици - Нематеријална штета-', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Породиља - Материјална штета -', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Грла - Материјана штета -', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Својина и предаја у државину', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Утврђујућа', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Такси - Материјана штета -', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Накнада штете - дуг', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Материјална штета - накнада', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Дискриминација', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Деоба', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Стицање без основа', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Клизиште', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Поништај решења', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Својина', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Обданиште - Накнада штете-', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Накнада изгубљене добити', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Дуг', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Исељење', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Поништај уговора', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Накнада штете', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Чинидба', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Закуп', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Брисање уписа', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Бунари', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Сметање државине', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Раскид уговора', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Уговор о делу', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Физичка деоба', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Стицање својства закупца на неодређено време', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Стечај', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Новчана надокнада', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Уређење међе', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Накнада за изузето земљиште', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Откуп стана', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Утврђење', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Реституција', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Конверзија', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Исправка уписа', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Сагласност', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Исправка', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Управни спор', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Собовица', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Приговор', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Изузимање', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Утврђивање јавног интереса', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Жалба', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Пшеница', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Уговор-кредит', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Кривична пријава', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Јагњад', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Стеона јуница', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Јуница', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Озакоњење', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Укњижба', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Допис катастру', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Упис права својине', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Повраћај књига и исплата казне за прекорачење рока', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Службеност пролаза', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Повраћај земљишта', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Остало', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'РТК', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Пријава потраживања', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Замолница', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Утврђивање права својине', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Одлука', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Решења катастра', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Претварање права коришћења у право својине', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Сметање поседа', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Правилник', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Исплата зараде', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Брисање хипотеке', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Привремена мера', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Пад у шахту', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Неосновано обогаћење', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'утврђивање ништавности', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Решење Градског већа', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Стрна жита', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Право коришћења', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Уговор о закупу', ]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Отуђење', ]);

        DB::table('s_vrste_predmeta')->insert(['naziv' => 'НЕМА ВРСТУ', ]);
        DB::commit();
    }

}
