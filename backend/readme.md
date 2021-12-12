# REST API бэкенда.

BASE URL:
`http://192.168.43.235:8080/api/`


## GET | POST `ping`
Проверка работоспособности.

## POST `generateArt`
Принимает в теле JSON-объект, внутри которого есть массив "words" с 4 русскими словами. Пример запроса:
```json
{
    "words": [
        "виртуальное",
        "помещение",
        "кинотеатр",
        "технологии"
    ]
}
```
Пример ответа:
```json
{
    "debugRun": "1639212436_9885",
    "result": {
        "results": [
            "http://http://192.168.43.235:8080/api/images/1639212476_1025805.png"
        ],
        "sources": {
            "synonymWords": [
                "инженерии",
                "киноматографический театр",
                "потенциальное",
                "ноу-хау"
            ],
            "phrase": "методика",
            "wordsImg": [
                {
                    "url": "https://live.staticflickr.com/0/51646462517_53ed21ea25_b.jpg"
                },
                {
                    "url": "https://live.staticflickr.com/7293/12639677485_3bd3b74c03_b.jpg"
                },
                {
                    "url": "https://live.staticflickr.com/7693/29067950920_b00b935d4b_b.jpg"
                },
                {
                    "url": "https://live.staticflickr.com/5737/30457501753_170841e69f_b.jpg"
                }
            ],
            "commonImg": {
                "url": "https://live.staticflickr.com/5706/22842871554_f246165ae3_b.jpg"
            },
            "synonymImgs": [
                {
                    "url": "https://live.staticflickr.com/8260/29479118673_19dbdef58a_b.jpg"
                },
                null,
                null,
                {
                    "url": "https://live.staticflickr.com/8017/29757996872_0c2488be73_b.jpg"
                }
            ]
        }
    }
}
```

## GET `images/{FILENAME}`
Возвращает изображение по его имени. Часть до `_` является timestamp, когда было создано это изображение, а после `_` -- случайное число.
Пример:
```http request
GET http://192.168.43.235:8080/api/images/1639212476_1025805.png
```

## GET `history/{N}`
Возвращает N последних сгенерированных изображений. Возвращает имена файлов. Пример:
```http request
GET http://192.168.43.235:8080/api/history/3
```

```json
[
    "1639212476_1025805.png",
    "1639204733_7237825.png",
    "1639195840_8393789.png"
]
```

-------
Также на сервере ведётся расширенное логирование всех запросов (в том числе варианты генераций текстовых фраз и изображений). Файл с логами называется так же, как поле debugRun из запроса `generateArt`.
