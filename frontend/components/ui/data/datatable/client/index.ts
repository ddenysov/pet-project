function generateRandomObjects() {
  // Список возможных имен для выбора
  const names = ["Alpha", "Bravo", "Charlie", "Delta", "Echo", "Foxtrot", "Golf", "Hotel", "India", "Juliet",
    "Kilo", "Lima", "Mike", "November", "Oscar", "Papa", "Quebec", "Romeo", "Sierra", "Tango"];

  const objects = [];

  for (let i = 1; i <= 20; i++) {
    const obj = {
      id: i,
      name: names[Math.floor(Math.random() * names.length)]
    };

    // Добавляем объект в массив
    objects.push(obj);
  }

  // Возвращаем массив объектов
  return objects;
}
export const useClient = () => {
  const fetchData = () => {
    const delayTime = () =>
      new Promise((resolve) => setTimeout(() => {
        resolve(generateRandomObjects())
      }, 1000));
    return delayTime();
  }

  return { fetchData }
}