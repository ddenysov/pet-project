### Track

- Покатушка створена 
- Доданий тыльки айді треку
  - Питання: як показати довжину треку в покатушці та назву треку?



- Зберегти трек айді
  - Де взяти трей нейм та довжину?
  - Если делать ГЕТ то где? В команд хендлере?

Полностью на ивентах
- Покатушки
  - Публикует событие: покатушка создана
- Пользователи
  - Слушает событие: покатушка создана
    - Обновляет проекции
    - Сохраняет айди агрегата в пользователе
  - Отправвляет собыите - пользователь создал покатушку

_______

Варианты:
- Не использовать саги все на ивентах
  - Плюсы
    - Достаточно понятно
    - Просто реализовать просто на ивент хендлерах
  - Минуси
    - Много ивентов служебных, хотелось бы чтоб были только те которые в ивентштормине
    - Агрегат не в целосном состоянии, меняеться поведение доменного слоя в угоду прикладному, не ок
- Использовать Сагу. В команд хендлере стартуем Сагу. Сага запускает первый степ, сохраняем локальный стейт саги. Вместо ивентов используем асинхронные запросы в репли ту
- 

_____

Окончательное решение
- Использовать HTTP запрос в другой сервис при созжании аггрегата, но только для тех данных которые учавствуют в бизнес логике
- Ивенты только доменные, тоесть реальные бизнес сценарии
- Рид модель создаеться когда создан аггрегат, и у него есть айди и тогда делаем запрос в сторонний сервис, если у нас в базе уже нет такой записи
- Слушаем апдейтед внешних агрегатов