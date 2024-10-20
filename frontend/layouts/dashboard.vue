<template>
  <div class="app">
    <!-- Боковое меню -->
    <div class="sidebar" :class="{ 'sidebar-collapsed': isCollapsed }">
      <div class="profile-section">
        <h4>Иван Иванов</h4>
      </div>
      <p-menu :model="menuItems" class="menu"></p-menu>
    </div>

    <!-- Основной контент -->
    <div class="main-content">
      <!-- Верхняя панель -->
      <div class="topbar">
        <button class="p-button p-button-text p-button-lg" @click="toggleSidebar">
          <i class="pi pi-bars"></i>
        </button>
        <div class="right-section">
          <span class="p-input-icon-left">
            <i class="pi pi-search"></i>
            <input type="text" pInputText placeholder="Поиск..." v-model="search" />
          </span>
          <button class="p-button p-button-text p-button-lg p-mr-2">
            <i class="pi pi-bell"></i>
            <span class="p-badge p-badge-danger">3</span>
          </button>
          <button class="p-button p-button-text p-button-lg">
            <i class="pi pi-envelope"></i>
            <span class="p-badge p-badge-warning">5</span>
          </button>
        </div>
      </div>

      <!-- Содержимое -->
      <div class="content">
        <!-- Панель управления -->
        <div v-if="activeSection === 'dashboard'">
          <h1>Панель управления</h1>
          <!-- Карточки статистики -->
          <div class="p-grid">
            <div class="p-col-12 p-md-3">
              <div class="card bg-primary text-white">
                <div class="card-body">
                  <i class="pi pi-compass" style="font-size: 2em; float: right;"></i>
                  <h5>Предстоящие покатушки</h5>
                  <h3>4</h3>
                </div>
                <div class="card-footer">
                  <a href="#" @click.prevent="activeSection = 'rides'" class="text-white">Подробнее</a>
                </div>
              </div>
            </div>
            <!-- Другие карточки аналогично -->
            <div class="p-col-12 p-md-3">
              <div class="card bg-warning text-white">
                <div class="card-body">
                  <i class="pi pi-map" style="font-size: 2em; float: right;"></i>
                  <h5>Мои маршруты</h5>
                  <h3>12</h3>
                </div>
                <div class="card-footer">
                  <a href="#" @click.prevent="activeSection = 'routes'" class="text-white">Подробнее</a>
                </div>
              </div>
            </div>
            <div class="p-col-12 p-md-3">
              <div class="card bg-success text-white">
                <div class="card-body">
                  <i class="pi pi-users" style="font-size: 2em; float: right;"></i>
                  <h5>Друзья</h5>
                  <h3>27</h3>
                </div>
                <div class="card-footer">
                  <a href="#" @click.prevent="activeSection = 'community'" class="text-white">Подробнее</a>
                </div>
              </div>
            </div>
            <div class="p-col-12 p-md-3">
              <div class="card bg-danger text-white">
                <div class="card-body">
                  <i class="pi pi-comments" style="font-size: 2em; float: right;"></i>
                  <h5>Новые сообщения</h5>
                  <h3>5</h3>
                </div>
                <div class="card-footer">
                  <a href="#" @click.prevent="activeSection = 'messages'" class="text-white">Подробнее</a>
                </div>
              </div>
            </div>
          </div>

          <!-- График активности -->
          <div class="p-grid">
            <div class="p-col-12 p-md-8">
              <div class="card">
                <div class="card-header">
                  <i class="pi pi-chart-line"></i>
                  <span>Активность за последние 7 дней</span>
                </div>
                <div class="card-body">
                  <canvas id="activityChart"></canvas>
                </div>
              </div>
            </div>
            <div class="p-col-12 p-md-4">
              <div class="card">
                <div class="card-header">
                  <i class="pi pi-clock"></i>
                  <span>Последние покатушки</span>
                </div>
                <div class="card-body">
                  <ul>
                    <li>Осенний заезд</li>
                    <li>Горный подъем</li>
                    <li>Ночной променад</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <!-- Таблица данных -->
          <div class="card">
            <div class="card-header">
              <i class="pi pi-table"></i>
              <span>Предстоящие покатушки</span>
            </div>
            <div class="card-body">
              <table class="p-datatable">
                <thead>
                <tr>
                  <th>Название</th>
                  <th>Дата</th>
                  <th>Участники</th>
                  <th>Дистанция</th>
                  <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="ride in rides" :key="ride.name">
                  <td>{{ ride.name }}</td>
                  <td>{{ ride.date }}</td>
                  <td>{{ ride.participants }}</td>
                  <td>{{ ride.distance }}</td>
                  <td>
                    <button class="p-button p-button-text" @click="viewRide(ride)">
                      <i class="pi pi-eye"></i>
                    </button>
                    <button class="p-button p-button-text" @click="joinRide(ride)">
                      <i class="pi pi-check"></i>
                    </button>
                    <button class="p-button p-button-text" @click="declineRide(ride)">
                      <i class="pi pi-times"></i>
                    </button>
                  </td>
                </tr>
                <!-- Дополнительные строки -->
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Профиль -->
        <div v-if="activeSection === 'profile'">
          <h1>Профиль</h1>
          <div class="card">
            <div class="card-header">
              <i class="pi pi-user-edit"></i>
              <span>Редактирование профиля</span>
            </div>
            <div class="card-body">
              <form @submit.prevent="saveProfile">
                <div class="p-fluid p-formgrid p-grid">
                  <div class="p-field p-col-12 p-md-6">
                    <label for="firstName">Имя</label>
                    <input id="firstName" type="text" pInputText v-model="profile.firstName" />
                  </div>
                  <div class="p-field p-col-12 p-md-6">
                    <label for="lastName">Фамилия</label>
                    <input id="lastName" type="text" pInputText v-model="profile.lastName" />
                  </div>
                  <div class="p-field p-col-12">
                    <label for="email">Электронная почта</label>
                    <input id="email" type="email" pInputText v-model="profile.email" />
                  </div>
                  <div class="p-field p-col-12">
                    <label for="address">Адрес</label>
                    <input id="address" type="text" pInputText v-model="profile.address" />
                  </div>
                  <div class="p-field p-col-12">
                    <label for="phone">Телефон</label>
                    <input id="phone" type="tel" pInputText v-model="profile.phone" />
                  </div>
                  <div class="p-field p-col-12">
                    <label for="bio">О себе</label>
                    <textarea id="bio" pInputTextarea v-model="profile.bio"></textarea>
                  </div>
                  <div class="p-field p-col-12">
                    <button type="submit" class="p-button">
                      Сохранить изменения
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Покатушки -->
        <div v-if="activeSection === 'rides'">
          <h1>Покатушки</h1>
          <p-tabview>
            <p-tabpanel header="Предстоящие">
              <div class="p-grid">
                <div class="p-col-12 p-md-6" v-for="ride in upcomingRides" :key="ride.name">
                  <div class="card">
                    <img :src="ride.image" alt="Изображение покатушки" class="card-img-top" />
                    <div class="card-body">
                      <h5>{{ ride.name }}</h5>
                      <p>Дата: {{ ride.date }}</p>
                      <button class="p-button" @click="viewRide(ride)">Подробнее</button>
                    </div>
                  </div>
                </div>
                <!-- Дополнительные карточки -->
              </div>
            </p-tabpanel>
            <p-tabpanel header="Прошедшие">
              <div class="p-grid">
                <div class="p-col-12 p-md-6" v-for="ride in pastRides" :key="ride.name">
                  <div class="card">
                    <img :src="ride.image" alt="Изображение покатушки" class="card-img-top" />
                    <div class="card-body">
                      <h5>{{ ride.name }}</h5>
                      <p>Дата: {{ ride.date }}</p>
                      <button class="p-button p-button-secondary" @click="viewReport(ride)">Посмотреть отчет</button>
                    </div>
                  </div>
                </div>
                <!-- Дополнительные карточки -->
              </div>
            </p-tabpanel>
            <p-tabpanel header="Мои покатушки">
              <button class="p-button p-button-success mb-3" @click="createRide">Создать новую покатушку</button>
              <div class="p-grid">
                <div class="p-col-12 p-md-6" v-for="ride in myRides" :key="ride.name">
                  <div class="card">
                    <img :src="ride.image" alt="Изображение покатушки" class="card-img-top" />
                    <div class="card-body">
                      <h5>{{ ride.name }}</h5>
                      <p>Дата: {{ ride.date }}</p>
                      <button class="p-button" @click="viewRide(ride)">Подробнее</button>
                      <button class="p-button p-button-warning" @click="editRide(ride)">Редактировать</button>
                      <button class="p-button p-button-danger" @click="cancelRide(ride)">Отменить</button>
                    </div>
                  </div>
                </div>
                <!-- Дополнительные карточки -->
              </div>
            </p-tabpanel>
          </p-tabview>
        </div>

        <!-- Маршруты -->
        <div v-if="activeSection === 'routes'">
          <h1>Маршруты</h1>
          <button class="p-button p-button-success mb-3" @click="createRoute">Создать новый маршрут</button>
          <table class="p-datatable">
            <thead>
            <tr>
              <th>Название</th>
              <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="route in routes" :key="route.name">
              <td>{{ route.name }}</td>
              <td>
                <button class="p-button p-button-text" @click="viewRoute(route)">
                  <i class="pi pi-eye"></i>
                </button>
                <button class="p-button p-button-text" @click="editRoute(route)">
                  <i class="pi pi-pencil"></i>
                </button>
                <button class="p-button p-button-text" @click="deleteRoute(route)">
                  <i class="pi pi-trash"></i>
                </button>
              </td>
            </tr>
            <!-- Дополнительные маршруты -->
            </tbody>
          </table>
        </div>

        <!-- Сообщество -->
        <div v-if="activeSection === 'community'">
          <h1>Сообщество</h1>
          <div class="p-grid">
            <!-- Список друзей -->
            <div class="p-col-12 p-md-6">
              <h3>Мои друзья</h3>
              <table class="p-datatable">
                <thead>
                <tr>
                  <th>Имя</th>
                  <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="friend in friends" :key="friend.name">
                  <td>{{ friend.name }}</td>
                  <td>
                      <span :class="{'p-tag': true, 'p-tag-success': friend.online, 'p-tag-secondary': !friend.online}">
                        {{ friend.online ? 'Онлайн' : 'Оффлайн' }}
                      </span>
                  </td>
                </tr>
                <!-- Дополнительные друзья -->
                </tbody>
              </table>
            </div>
            <!-- Поиск новых друзей -->
            <div class="p-col-12 p-md-6">
              <h3>Найти друзей</h3>
              <div class="p-inputgroup mb-3">
                <input type="text" pInputText placeholder="Имя пользователя" v-model="searchTerm" />
                <button class="p-button" @click="searchFriends">
                  <i class="pi pi-search"></i>
                </button>
              </div>
              <table class="p-datatable">
                <thead>
                <tr>
                  <th>Имя</th>
                  <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in searchResults" :key="user.name">
                  <td>{{ user.name }}</td>
                  <td>
                    <button class="p-button" @click="addFriend(user)">Добавить в друзья</button>
                  </td>
                </tr>
                <!-- Дополнительные результаты -->
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Сообщения -->
        <div v-if="activeSection === 'messages'">
          <h1>Сообщения</h1>
          <div class="p-grid">
            <!-- Список контактов -->
            <div class="p-col-12 p-md-4">
              <p-listbox v-model="selectedContact" :options="contacts" optionLabel="name" @change="selectContact"></p-listbox>
            </div>
            <!-- Окно переписки -->
            <div class="p-col-12 p-md-8">
              <div class="card">
                <div class="card-header">
                  Переписка с {{ selectedContact ? selectedContact.name : '' }}
                </div>
                <div class="card-body chat-window">
                  <div v-for="message in messages" :key="message.id" class="message">
                    <strong>{{ message.sender }}:</strong> {{ message.text }}
                  </div>
                </div>
                <div class="card-footer message-input">
                  <input type="text" pInputText v-model="messageText" placeholder="Введите сообщение" @keyup.enter="sendMessage" />
                  <button class="p-button" @click="sendMessage">
                    <i class="pi pi-send"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Настройки -->
        <div v-if="activeSection === 'settings'">
          <h1>Настройки</h1>
          <div class="card">
            <div class="card-header">
              <i class="pi pi-cog"></i>
              <span>Настройки аккаунта</span>
            </div>
            <div class="card-body">
              <!-- Изменение пароля -->
              <h5>Изменить пароль</h5>
              <form @submit.prevent="changePassword">
                <div class="p-fluid">
                  <div class="p-field">
                    <label for="currentPassword">Текущий пароль</label>
                    <input id="currentPassword" type="password" pPassword v-model="passwords.current" />
                  </div>
                  <div class="p-field">
                    <label for="newPassword">Новый пароль</label>
                    <input id="newPassword" type="password" pPassword v-model="passwords.new" />
                  </div>
                  <div class="p-field">
                    <label for="confirmPassword">Подтвердите новый пароль</label>
                    <input id="confirmPassword" type="password" pPassword v-model="passwords.confirm" />
                  </div>
                  <button type="submit" class="p-button">Обновить пароль</button>
                </div>
              </form>
              <p-divider></p-divider>
              <!-- Настройки уведомлений -->
              <h5>Настройки уведомлений</h5>
              <div class="p-field-checkbox">
                <p-checkbox inputId="emailNotifications" v-model="notifications.email"></p-checkbox>
                <label for="emailNotifications">Получать уведомления по электронной почте</label>
              </div>
              <div class="p-field-checkbox">
                <p-checkbox inputId="smsNotifications" v-model="notifications.sms"></p-checkbox>
                <label for="smsNotifications">Получать SMS-уведомления</label>
              </div>
              <button class="p-button mt-3" @click="saveSettings">Сохранить настройки</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isCollapsed: false,
      search: '',
      activeSection: 'dashboard',
      menuItems: [
        {
          label: 'Панель управления',
          icon: 'pi pi-fw pi-home',
          command: () => {
            this.activeSection = 'dashboard';
          },
        },
        {
          label: 'Профиль',
          icon: 'pi pi-fw pi-user',
          command: () => {
            this.activeSection = 'profile';
          },
        },
        {
          label: 'Покатушки',
          icon: 'pi pi-fw pi-compass',
          command: () => {
            this.activeSection = 'rides';
          },
        },
        {
          label: 'Маршруты',
          icon: 'pi pi-fw pi-map',
          command: () => {
            this.activeSection = 'routes';
          },
        },
        {
          label: 'Сообщество',
          icon: 'pi pi-fw pi-users',
          command: () => {
            this.activeSection = 'community';
          },
        },
        {
          label: 'Сообщения',
          icon: 'pi pi-fw pi-envelope',
          command: () => {
            this.activeSection = 'messages';
          },
        },
        {
          label: 'Настройки',
          icon: 'pi pi-fw pi-cog',
          command: () => {
            this.activeSection = 'settings';
          },
        },
        {
          separator: true,
        },
        {
          label: 'Выход',
          icon: 'pi pi-fw pi-sign-out',
          command: () => {
            // Реализация выхода
          },
        },
      ],
      // Данные для различных секций
      rides: [
        {
          name: 'Осенний заезд',
          date: '25.10.2024',
          participants: 15,
          distance: '30 км',
        },
        // Дополнительные данные
      ],
      profile: {
        firstName: 'Иван',
        lastName: 'Иванов',
        email: 'ivanov@example.com',
        address: 'ул. Ленина, д. 10',
        phone: '+7 (900) 123-45-67',
        bio: 'Люблю велопрогулки и активный отдых.',
      },
      upcomingRides: [
        {
          name: 'Осенний заезд',
          date: '25 октября 2024',
          image: 'ride1.jpg',
        },
        // Дополнительные покатушки
      ],
      pastRides: [
        {
          name: 'Летний спринт',
          date: '10 июля 2024',
          image: 'ride2.jpg',
        },
        // Дополнительные покатушки
      ],
      myRides: [
        {
          name: 'Весенний променад',
          date: '5 мая 2024',
          image: 'ride3.jpg',
        },
        // Дополнительные покатушки
      ],
      routes: [
        {
          name: 'Городские улицы',
        },
        {
          name: 'Горный подъем',
        },
        // Дополнительные маршруты
      ],
      friends: [
        {
          name: 'Петр Петров',
          online: true,
        },
        {
          name: 'Анна Смирнова',
          online: false,
        },
        // Дополнительные друзья
      ],
      searchTerm: '',
      searchResults: [],
      contacts: [
        { name: 'Петр Петров' },
        { name: 'Анна Смирнова' },
        // Дополнительные контакты
      ],
      selectedContact: null,
      messages: [],
      messageText: '',
      passwords: {
        current: '',
        new: '',
        confirm: '',
      },
      notifications: {
        email: true,
        sms: false,
      },
    };
  },
  methods: {
    toggleSidebar() {
      this.isCollapsed = !this.isCollapsed;
    },
    // Методы для панели управления
    viewRide(ride) {
      // Реализация просмотра покатушки
    },
    joinRide(ride) {
      // Реализация присоединения к покатушке
    },
    declineRide(ride) {
      // Реализация отказа от покатушки
    },
    // Методы для профиля
    saveProfile() {
      // Реализация сохранения профиля
    },
    // Методы для покатушек
    createRide() {
      // Реализация создания покатушки
    },
    editRide(ride) {
      // Реализация редактирования покатушки
    },
    cancelRide(ride) {
      // Реализация отмены покатушки
    },
    viewReport(ride) {
      // Реализация просмотра отчета
    },
    // Методы для маршрутов
    createRoute() {
      // Реализация создания маршрута
    },
    viewRoute(route) {
      // Реализация просмотра маршрута
    },
    editRoute(route) {
      // Реализация редактирования маршрута
    },
    deleteRoute(route) {
      // Реализация удаления маршрута
    },
    // Методы для сообщества
    searchFriends() {
      // Реализация поиска друзей
    },
    addFriend(user) {
      // Реализация добавления в друзья
    },
    // Методы для сообщений
    selectContact() {
      // Реализация выбора контакта
      this.messages = [
        // Загрузить сообщения для выбранного контакта
      ];
    },
    sendMessage() {
      if (this.messageText.trim() !== '') {
        this.messages.push({
          id: Date.now(),
          sender: 'Вы',
          text: this.messageText,
        });
        this.messageText = '';
      }
    },
    // Методы для настроек
    changePassword() {
      // Реализация изменения пароля
    },
    saveSettings() {
      // Реализация сохранения настроек
    },
  },
  mounted() {
    // Инициализация графика активности
    const ctx = document.getElementById('activityChart').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'],
        datasets: [
          {
            label: 'Км пройдено',
            data: [12, 19, 3, 5, 2, 3, 9],
            fill: false,
            borderColor: '#42A5F5',
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
      },
    });
  },
};
</script>

<style scoped>
.app {
  display: flex;
}

.sidebar {
  width: 250px;
  background-color: #343a40;
  color: #fff;
  height: 100vh;
  position: fixed;
  overflow-y: auto;
  transition: width 0.3s;
}

.sidebar-collapsed {
  width: 80px;
}

.profile-section {
  text-align: center;
  padding: 20px;
}

.avatar {
  border-radius: 50%;
  width: 80px;
}

.menu {
  border: none;
}

.main-content {
  margin-left: 250px;
  flex: 1;
  display: flex;
  flex-direction: column;
  transition: margin-left 0.3s;
}

.sidebar-collapsed + .main-content {
  margin-left: 80px;
}

.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  background-color: #fff;
  border-bottom: 1px solid #dee2e6;
}

.right-section {
  display: flex;
  align-items: center;
}

.right-section .p-input-icon-left {
  margin-right: 10px;
}

.content {
  padding: 20px;
  background-color: #f8f9fa;
  min-height: calc(100vh - 60px);
}

.card {
  margin-bottom: 20px;
}

.bg-primary {
  background-color: #007bff !important;
}

.bg-warning {
  background-color: #ffc107 !important;
}

.bg-success {
  background-color: #28a745 !important;
}

.bg-danger {
  background-color: #dc3545 !important;
}

.text-white {
  color: #fff !important;
}

.card-footer {
  background-color: rgba(0, 0, 0, 0.03);
  padding: 0.75rem 1.25rem;
}

.card-footer a {
  color: inherit;
  text-decoration: none;
}

.p-datatable {
  width: 100%;
}

.p-datatable th,
.p-datatable td {
  padding: 0.75rem;
  text-align: left;
}

.chat-window {
  height: 300px;
  overflow-y: auto;
  margin-bottom: 10px;
}

.message {
  margin-bottom: 10px;
}

.message-input {
  display: flex;
}

.message-input .p-inputtext {
  flex: 1;
  margin-right: 5px;
}
</style>
