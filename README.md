# Hungre People
- [Веб-сайт](https://hungre-people.csasq.ru)
- [Веб-почта](https://mail.csasq.ru)

## Конфигурация
Файл находится за пределами проекта в семантически-корректной директории конфигураций хоста Linux: `/usr/local/etc/hungre-people.csasq.ru/config.php`.

Пример файла конфигурации:

```
<?php

    $config['db:coninfo'] = 'mysql:host=%host;port=%port;dbname=%dbname';
    $config['db:username'] = '%username';
    $config['db:password'] = '%password';

    $config['smtp:hostname'] = '%hostname';
    $config['smtp:name'] = '%name';
    $config['smtp:username'] = '%username';
    $config['smtp:password'] = '%password';

?>
```
