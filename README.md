# Написать Symfony REST-приложение для расчета цены продукта и проведения оплаты

Необходимо реализовать 2 эндпоинта:
1. POST: для расчёта цены

http://127.0.0.1:8337/calculate-price

Пример JSON тела запроса:
```
{
    "product": 1,
    "taxNumber": "DE123456789",
    "couponCode": "D15"
}
```
2. POST: для осуществления покупки

http://127.0.0.1:8337/purchase

Пример JSON тела запроса:
```
{
    "product": 1,
    "taxNumber": "IT12345678900",
    "couponCode": "D15",
    "paymentProcessor": "paypal"
}
```
