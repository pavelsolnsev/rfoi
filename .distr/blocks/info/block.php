<section class="s-main info-page">
  
  <div class="container">
    <div class="info-page__content">
      <div class="info-page__header">
        <a href="/" class="info-page__home" title="На главную" aria-label="На главную">
          <i class="fas fa-home"></i>
          <span>На главную</span>
        </a>
        <h1>Информация</h1>
      </div>
      
      <!-- Основные табы -->
      <ul class="nav nav-tabs info-page__main-tabs " id="mainTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="football-tab" data-bs-toggle="tab" data-bs-target="#football" type="button" role="tab" aria-controls="football" aria-selected="true">
            Футбол для всех
          </button>
        </li>


        <li class="nav-item" role="presentation">
          <button class="nav-link" id="tournament-tab" data-bs-toggle="tab" data-bs-target="#tournament" type="button" role="tab" aria-controls="tournament" aria-selected="false">
            Турнир
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="rating-tab" data-bs-toggle="tab" data-bs-target="#rating" type="button" role="tab" aria-controls="rating" aria-selected="false">
            Рейтинг
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="mvp-tab" data-bs-toggle="tab" data-bs-target="#mvp" type="button" role="tab" aria-controls="mvp" aria-selected="false">
            MVP
          </button>
        </li>
      </ul>

      <!-- Контент табов -->
      <div class="tab-content" id="mainTabsContent">
        <!-- Таб Футбол -->
        <div class="tab-pane fade show active info-page__panel" id="football" role="tabpanel" aria-labelledby="football-tab">
          <div class="football-content">
            <div class="football-intro mb-4">
              <h2 class="mb-3 d-flex align-items-center">
                <span>Любой желающий может сыграть!</span>
              </h2>
              <p class="lead">Организуем матчи в Раменском — записывайся и играй!</p>
            </div>

            <div class="football-vk-cta mb-4" role="region" aria-label="Сообщество ВКонтакте">
              <h3 class="mb-3 d-flex align-items-center flex-wrap gap-2">
                <i class="fab fa-vk" style="font-size: 1.35rem; color: #2787F5;" aria-hidden="true"></i>
                <span>ВКонтакте: подписка и чат</span>
              </h3>
              <div class="p-3 p-md-4 rounded shadow-sm" style="background: linear-gradient(135deg, #e8f4ff 0%, #dbeafe 45%, #eff6ff 100%); border: 1px solid rgba(39, 135, 245, 0.35); border-left: 5px solid #2787F5;">
                <p class="mb-3 fw-semibold mb-md-4" style="color: #1e3a5f;">Подпишись на сообщество и вступи в чат — там анонсы игр и турниров, запись и общение участников.</p>
                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="h-100 p-3 rounded" style="background: rgba(255, 255, 255, 0.9); border: 1px solid rgba(39, 135, 245, 0.22);">
                      <div class="text-muted small mb-1">Шаг 1</div>
                      <strong class="d-block mb-2">Сообщество</strong>
                      <a class="btn btn-primary w-100 d-inline-flex align-items-center justify-content-center gap-2" style="background: #2787F5; border-color: #2787F5;" href="https://vk.com/rmsfootball" target="_blank" rel="noopener noreferrer"><i class="fab fa-vk" aria-hidden="true"></i><span>Подписаться — РФОИ</span></a>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="h-100 p-3 rounded" style="background: rgba(255, 255, 255, 0.9); border: 1px solid rgba(39, 135, 245, 0.22);">
                      <div class="text-muted small mb-1">Шаг 2</div>
                      <strong class="d-block mb-2">Чат сообщества</strong>
                      <a class="btn w-100 d-inline-flex align-items-center justify-content-center gap-2" style="border: 2px solid #2787F5; color: #1856a8; background: #fff;" href="https://vk.me/join/D/st103iIqXvHn2Y2tU1H1mHa2tomwwydbw=" target="_blank" rel="noopener noreferrer"><i class="fab fa-vk" style="color: #2787F5;" aria-hidden="true"></i><span>Вступить в чат</span></a>
                    </div>
                  </div>
                </div>
                <p class="mb-0 mt-3 small text-muted">Ссылки: <a class="d-inline-flex align-items-center gap-1" href="https://vk.com/rmsfootball" target="_blank" rel="noopener noreferrer"><i class="fab fa-vk" style="color: #2787F5;" aria-hidden="true"></i><span>vk.com/rmsfootball</span></a> · <a class="d-inline-flex align-items-center gap-1" href="https://vk.me/join/D/st103iIqXvHn2Y2tU1H1mHa2tomwwydbw=" target="_blank" rel="noopener noreferrer"><i class="fab fa-vk" style="color: #2787F5;" aria-hidden="true"></i><span>приглашение в чат</span></a></p>
              </div>
            </div>

            <div class="football-signup mb-4">
              <h3 class="mb-3 d-flex align-items-center">
                <span style="font-size: 1.5rem; margin-right: 8px;">🏃</span>
                <span>Как записаться на игру:</span>
              </h3>
              <div class="signup-info p-3 rounded mb-3" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-left: 4px solid #10b981;">
                <ul class="mb-0 ps-3">
                  <li>Напиши <strong>"+"</strong> или нажми <strong>"⚽️ Играть"</strong></li>
                  <li>Перед игрой в <strong>12:00</strong> создаётся матч со списком игроков</li>
                </ul>
                
              </div>
              <div class="signup-notes">
                <p class="mb-2"><strong>❎</strong> Попал в очередь? Бот уведомит, если место освободится.</p>
                <p class="mb-0"><strong>❗️</strong> Передумал? Напиши <strong>"−"</strong></p>
              </div>
            </div>

            <div class="football-bot mb-4 d-none" aria-hidden="true">
              <h3 class="mb-3">☑️ Полезные команды бота</h3>
              <div class="p-3 mb-3 rounded shadow-sm" style="background: linear-gradient(135deg, #e0f2fe 0%, #dbeafe 100%); border: 1px solid rgba(34, 158, 217, 0.3); border-left: 5px solid #229ed9;">
                <p class="small text-muted mb-2 mb-md-3">Команды отправляй в личные сообщения боту:</p>
                <a class="btn text-white w-100 d-inline-flex align-items-center justify-content-center gap-2" style="background: #229ed9; border-color: #229ed9;" href="https://t.me/football_ramen_bot" target="_blank" rel="noopener noreferrer"><i class="fab fa-telegram" aria-hidden="true"></i><span>Открыть @football_ramen_bot</span></a>
              </div>
              <div class="bot-commands">
                <div class="command-item p-3 mb-2 rounded shadow-sm" style="background: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #229ed9;">
                  До старта игры напиши боту <strong>«список»</strong> — текущие участники.
                </div>
                <div class="command-item p-3 mb-2 rounded shadow-sm" style="background: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #229ed9;">
                  После старта — <strong>«таблица»</strong> (составы команд) или <strong>«результаты»</strong>.
                </div>
              </div>
            </div>

            <div class="football-location mb-4">
              <h3 class="mb-3 d-flex align-items-center">
                <span style="font-size: 1.5rem; margin-right: 8px;">📍</span>
                <span>ГДЕ ПРОХОДИТ ИГРА?</span>
              </h3>
              <div class="location-list">
                <div class="location-item p-3 mb-3 rounded shadow-sm" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border: 1px solid rgba(245, 158, 11, 0.35); border-left: 5px solid #f59e0b;">
                  <strong class="d-block" style="color: #92400e;">Поле «Профилакторий»</strong> <small class="text-muted">(для всех желающих)</small>
                  <p class="mt-2 mb-0 fw-medium" style="color: #78350f;">ул. Махова, д. 18, Раменское</p>
                  <small class="text-muted d-block mb-3">(зимой закрыт)</small>
                  <a class="btn btn-sm text-white" style="background: #fc3f1d; border-color: #fc3f1d;" href="https://yandex.ru/maps/?text=Раменское, ул. Махова, д. 18" target="_blank" rel="noopener noreferrer">Открыть в Яндекс.Картах</a>
                </div>
                <div class="location-item p-3 mb-2 rounded shadow-sm" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border: 1px solid rgba(245, 158, 11, 0.35); border-left: 5px solid #f59e0b;">
                  <strong class="d-block" style="color: #92400e;">«Красное Знамя»</strong> <small class="text-muted">(турнир)</small>
                  <p class="mt-2 mb-0 fw-medium" style="color: #78350f;">ул. Воровского, 4Б, Раменское</p>
                  <small class="text-muted d-block mb-3">(зимой зал, летом поле)</small>
                  <a class="btn btn-sm text-white" style="background: #fc3f1d; border-color: #fc3f1d;" href="https://yandex.ru/maps/?text=Раменское, ул. Воровского, 4Б" target="_blank" rel="noopener noreferrer">Открыть в Яндекс.Картах</a>
                </div>
              </div>
            </div>

            <div class="football-schedule mb-4">
              <h3 class="mb-3 d-flex align-items-center">
                <span style="font-size: 1.5rem; margin-right: 8px;">📆</span>
                <span>ДАТА И ВРЕМЯ:</span>
              </h3>
              <div class="schedule-list">
                <div class="schedule-item p-2 mb-2 rounded" style="background: #f0f9ff; border-left: 3px solid #0ea5e9;">
                  <strong>Профилакторий</strong> <small class="text-muted">(для всех желающих)</small>: Каждый понедельник в 20:30 (1.5ч) <small class="text-muted">(зимой не доступно)</small>
                </div>
                <div class="schedule-item p-2 mb-2 rounded" style="background: #f0f9ff; border-left: 3px solid #0ea5e9;">
                  <strong>Красное Знамя</strong> <small class="text-muted">(турнир)</small>: Каждую пятницу в 20:00 (2ч) <small class="text-muted">(зимой зал, летом поле)</small>
                </div>
              </div>
            </div>

            <div class="football-format mb-4">
              <h3 class="mb-3 d-flex align-items-center">
                <span style="font-size: 1.5rem; margin-right: 8px;">🥅</span>
                <span>ФОРМАТ:</span>
              </h3>
              <div class="format-info p-3 rounded mb-3" style="background: #faf5ff; border-left: 4px solid #8b5cf6;">
                <ul class="mb-2 ps-3">
                  <li><strong>Профилакторий</strong> <small class="text-muted">(для всех желающих)</small>: 5x5</li>
                  <li><strong>Красное Знамя</strong> <small class="text-muted">(турнир)</small>: летом поле 8x8, зимой зал 5x5</li>
                  <li>От <strong>2 до 4 команд</strong></li>
                  <li>Длительность: <strong>6 минут</strong> или <strong>3 забитых мяча</strong></li>
                  <li>Играем <strong>каждый с каждым</strong> (несколько кругов)</li>
                </ul>
              </div>
            </div>

            <div class="football-payment mb-4">
              <h3 class="mb-3">💰 Стоимость и оплата:</h3>
              <div class="payment-info p-3 rounded mb-3" style="background: #ecfdf5; border-left: 4px solid #10b981;">
                <p class="mb-2"><strong>Стоимость участия: 500 рублей</strong></p>
                <p class="mb-2">В стоимость входит:</p>
                <ul class="mb-0 ps-3">
                  <li>Аренда поля</li>
                  <li>Вода</li>
                  <li>Манишки</li>
                  <li>Мячи</li>
                  <li>Съёмка и трансляция</li>
                  <li>Аптечка со всем необходимым</li>
                  <li>Музыка</li>
                </ul>
              </div>
              <div class="payment-methods">
                <div class="payment-item p-3 p-md-4 mb-3 rounded shadow-sm" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfccb 45%, #f7fee7 100%); border: 1px solid rgba(33, 160, 56, 0.28); border-left: 5px solid #21a038;">
                  <strong class="d-block mb-1" style="color: #14532d;">Оплата переводом (Сбербанк)</strong>
                  <p class="small text-muted mb-3 mb-md-3">Номер для перевода или быстрая оплата по ссылке</p>
                  <div class="p-3 rounded mb-3" style="background: rgba(255, 255, 255, 0.92); border: 1px solid rgba(33, 160, 56, 0.2);">
                    <span class="text-muted small d-block mb-1">Телефон (нажми, чтобы скопировать)</span>
                    <span class="copy-phone d-inline-flex align-items-center flex-wrap gap-1" data-phone="+79166986185" title="Нажми, чтобы скопировать номер" role="button" tabindex="0">
                      <strong style="color: #15803d; font-size: 1.05rem;">+7 (916) 698-61-85</strong>
                      <i class="fas fa-copy" style="color: #21a038; font-size: 0.9em;" aria-hidden="true"></i>
                    </span>
                  </div>
                  <a class="btn text-white w-100" style="background: #21a038; border-color: #21a038;" href="https://messenger.online.sberbank.ru/sl/JWnaTcQf0aviSEAxy" target="_blank" rel="noopener noreferrer">Оплатить участие — Сбер</a>
                </div>
                <div class="payment-item p-3 mb-2 rounded shadow-sm" style="background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%); border: 1px solid rgba(234, 88, 12, 0.25); border-left: 4px solid #ea580c;">
                  <strong style="color: #9a3412;">💵 Наличными</strong>
                  <span class="d-block small mt-1 text-muted">Можно оплатить на месте перед игрой</span>
                </div>
              </div>
            </div>

            <div class="football-rating mb-4">
              <h3 class="mb-3 d-flex align-items-center">
                <span style="font-size: 1.5rem; margin-right: 8px;">🏆</span>
                <span>Рейтинг</span>
              </h3>
              <p class="mb-3">После каждой игры формируется личный рейтинг игрока. Плюсы за гол, пас, сейв, победу и ничью умножаются на <strong>mod</strong> (см. вкладку «Рейтинг»); штрафы за поражение и жёлтую — без mod.</p>
              <div class="rating-list mb-3">
                <div class="rating-item p-2 mb-2 rounded" style="background: #f0fdf4; border-left: 3px solid #10b981;">
                  <strong>Гол:</strong> +0.3 × mod
                </div>
                <div class="rating-item p-2 mb-2 rounded" style="background: #f0fdf4; border-left: 3px solid #10b981;">
                  <strong>Пас:</strong> +0.3 × mod
                </div>
                <div class="rating-item p-2 mb-2 rounded" style="background: #f0fdf4; border-left: 3px solid #10b981;">
                  <strong>Сейв:</strong> +0.2 × mod
                </div>
                <div class="rating-item p-2 mb-2 rounded" style="background: #f0fdf4; border-left: 3px solid #10b981;">
                  <strong>Победа:</strong> +1.8 × mod
                </div>
                <div class="rating-item p-2 mb-2 rounded" style="background: #f0fdf4; border-left: 3px solid #10b981;">
                  <strong>Ничья:</strong> +0.5 × mod
                </div>
                <div class="rating-item p-2 mb-2 rounded" style="background: #fef2f2; border-left: 3px solid #ef4444;">
                  <strong>Поражение:</strong> −1.3 <small class="text-muted">(«сухое» −1.8; без mod)</small>
                </div>
              </div>
              <p class="mb-3">Чем выше рейтинг, тем меньше очков будет начисляться.</p>
              <div class="rating-levels p-3 rounded" style="background: #fffbeb; border-left: 4px solid #f59e0b;">
                <p class="mb-2"><strong>Уровни рейтинга:</strong></p>
                <ul class="mb-0 ps-3">
                  <li><strong>⭐️:</strong> &lt;10</li>
                  <li><strong>💫:</strong> 10–29</li>
                  <li><strong>✨:</strong> 30–59</li>
                  <li><strong>🌠:</strong> 60–99</li>
                  <li><strong>💎:</strong> 100–149</li>
                  <li><strong>🏆:</strong> ≥150</li>
                </ul>
              </div>
            </div>

            <div class="football-media">
              <h3 class="mb-3 d-flex align-items-center">
                <span style="font-size: 1.5rem; margin-right: 8px;">📸</span>
                <span>Медиа</span>
              </h3>
              <div class="media-links">
                <div class="media-item p-3 p-md-4 mb-3 rounded shadow-sm" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 40%, #f0fdf4 100%); border: 1px solid rgba(5, 150, 105, 0.3); border-left: 5px solid #059669;">
                  <strong class="d-block mb-1" style="color: #064e3b;">Сайт учёта матчей</strong>
                  <p class="small text-muted mb-3">Рейтинги игроков, турниры и команды</p>
                  <div class="d-grid gap-2">
                    <a class="btn text-white" style="background: #059669; border-color: #059669;" href="https://football.pavelsolntsev.ru" target="_blank" rel="noopener noreferrer">Игроки и таблица рейтинга</a>
                    <a class="btn" style="border: 2px solid #059669; color: #047857; background: #fff;" href="https://football.pavelsolntsev.ru/tournament/" target="_blank" rel="noopener noreferrer">Турниры и команды</a>
                  </div>
                  <p class="mb-0 mt-3 small text-muted text-center">football.pavelsolntsev.ru</p>
                </div>
                <div class="media-item p-3 p-md-4 mb-3 rounded shadow-sm" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 40%, #faf5ff 100%); border: 1px solid rgba(99, 102, 241, 0.3); border-left: 5px solid #6366f1;">
                  <strong class="d-block mb-1" style="color: #312e81;">Онлайн-турнир</strong>
                  <p class="small text-muted mb-3">Ход игры, итоги, архив</p>
                  <a class="btn w-100 text-white" style="background: #4f46e5; border-color: #4f46e5;" href="https://tournament.pavelsolntsev.ru/" target="_blank" rel="noopener noreferrer">Открыть</a>
                </div>
                <div class="media-item p-3 mb-3 rounded shadow-sm" style="background: linear-gradient(135deg, #e8f4ff 0%, #f0f9ff 100%); border: 1px solid rgba(39, 135, 245, 0.35); border-left: 5px solid #2787F5;">
                  <strong class="d-flex align-items-center gap-2 mb-2" style="color: #1e3a5f;"><i class="fab fa-vk" style="color: #2787F5; font-size: 1.25rem;" aria-hidden="true"></i>ВКонтакте</strong>
                  <div class="d-grid gap-2">
                    <a class="btn btn-primary d-inline-flex align-items-center justify-content-center gap-2" style="background: #2787F5; border-color: #2787F5;" href="https://vk.com/rmsfootball" target="_blank" rel="noopener noreferrer"><i class="fab fa-vk" aria-hidden="true"></i><span>Сообщество РФОИ</span></a>
                    <a class="btn d-inline-flex align-items-center justify-content-center gap-2" style="border: 2px solid #2787F5; color: #1856a8; background: #fff;" href="https://vk.me/join/D/st103iIqXvHn2Y2tU1H1mHa2tomwwydbw=" target="_blank" rel="noopener noreferrer"><i class="fab fa-vk" style="color: #2787F5;" aria-hidden="true"></i><span>Чат сообщества</span></a>
                  </div>
                </div>
                <div class="media-item p-3 p-md-4 mb-2 rounded shadow-sm" style="background: linear-gradient(135deg, #e0f2fe 0%, #dbeafe 50%, #eff6ff 100%); border: 1px solid rgba(34, 158, 217, 0.35); border-left: 5px solid #229ed9;">
                  <strong class="d-flex align-items-center gap-2 mb-1" style="color: #0c4a6e;"><i class="fab fa-telegram" style="color: #229ed9; font-size: 1.25rem;" aria-hidden="true"></i>Telegram</strong>
                  <p class="small text-muted mb-3">Новости и обсуждения</p>
                  <a class="btn w-100 text-white d-inline-flex align-items-center justify-content-center gap-2" style="background: #229ed9; border-color: #229ed9;" href="https://t.me/RmsFootball" target="_blank" rel="noopener noreferrer"><i class="fab fa-telegram" aria-hidden="true"></i><span>Канал РФОИ</span></a>
                  <p class="mb-0 mt-2 small text-muted text-center d-flex align-items-center justify-content-center gap-1 flex-wrap"><i class="fab fa-telegram" style="color: #229ed9;" aria-hidden="true"></i><span>Новости и анонсы РФОИ в Telegram</span></p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Таб Рейтинг -->
        <div class="tab-pane fade info-page__panel" id="rating" role="tabpanel" aria-labelledby="rating-tab">
          <div class="rating-content">
            <div class="rating-intro mb-4">
              <h2 class="mb-3">Система рейтинга</h2>
              <div class="rating-description p-3 rounded mb-4" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-left: 4px solid #3b82f6;">
                <p class="mb-2"><strong>Рейтинг</strong> — это число, которое показывает твой вклад в игры.</p>
                <p class="mb-0">Максимум рейтинга — <strong>200</strong> (при сохранении в базу значение ограничивается сверху, ниже нуля не опускается). Итоговый рейтинг округляется до 1 знака после запятой.</p>
              </div>
            </div>

            <div class="rating-mod mb-4">
              <h3 class="mb-3 d-flex align-items-center">
                <span class="badge bg-warning text-dark me-2">mod</span>
                <span>коэффициент роста (важно)</span>
              </h3>
              <div class="mod-info p-3 rounded" style="background: #fff7ed; border-left: 4px solid #f59e0b;">
                <ul class="mb-2 ps-3">
                  <li>Почти все "плюсы" умножаются на <strong>mod</strong></li>
                  <li>Чем выше твой базовый рейтинг, тем меньше <strong>mod</strong> и тем меньше прибавка за те же действия.</li>
                  <li>Минимум <strong>mod</strong> — <strong>0.2</strong>.</li>
                  <li>Максимум <strong>mod</strong> — <strong>1</strong>.</li>
                </ul>
                <p class="mb-0 ps-3" style="font-family: monospace; background: rgba(0,0,0,0.05); padding: rem(8); border-radius: rem(4);">
                  <strong>Формула:</strong> mod = max(0.2, 1 - базовый_рейтинг / 250)
                </p>
              </div>
            </div>

            <div class="rating-points mb-4">
              <h3 class="mb-3 d-flex align-items-center">
                <span style="font-size: 1.5rem; margin-right: 8px;">⚽️</span>
                <span>За что начисляются очки</span>
              </h3>
              <p class="text-muted mb-3"><em>(все значения ниже умножаются на mod)</em></p>
              
              <div class="points-section mb-3">
                <h4 class="mb-2" style="color: #10b981; font-size: 1.1rem;">Базовые действия:</h4>
                <div class="points-list">
                  <div class="point-item p-2 mb-2 rounded" style="background: #f0fdf4; border-left: 3px solid #10b981;">
                    <strong>Гол:</strong> +0.3 × mod
                  </div>
                  <div class="point-item p-2 mb-2 rounded" style="background: #f0fdf4; border-left: 3px solid #10b981;">
                    <strong>Ассист:</strong> +0.3 × mod
                  </div>
                  <div class="point-item p-2 mb-2 rounded" style="background: #f0fdf4; border-left: 3px solid #10b981;">
                    <strong>Сейв:</strong> +0.2 × mod
                  </div>
                </div>
              </div>

              <div class="points-section mb-3">
                <h4 class="mb-2" style="color: #3b82f6; font-size: 1.1rem;">Результат матча:</h4>
                <div class="points-list">
                  <div class="point-item p-2 mb-2 rounded" style="background: #eff6ff; border-left: 3px solid #3b82f6;">
                    <strong>Победа:</strong> +1.8 × mod
                  </div>
                  <div class="point-item p-2 mb-2 rounded" style="background: #eff6ff; border-left: 3px solid #3b82f6;">
                    <strong>Ничья:</strong> +0.5 × mod
                  </div>
                  <div class="point-item p-2 mb-2 rounded" style="background: #eff6ff; border-left: 3px solid #3b82f6;">
                    <strong>"Сухая победа"</strong> (победа + забили 3+ гола + соперник 0): дополнительно +0.5 × mod
                    <br><small class="text-muted">(то есть победа в сумме станет +2.5 × mod, плюс ещё могут быть другие бонусы)</small>
                  </div>
                </div>
              </div>

              <div class="points-section mb-3">
                <h4 class="mb-2" style="color: #8b5cf6; font-size: 1.1rem;">Личные бонусы:</h4>
                
                <div class="mb-3">
                  <h5 class="mb-2" style="color: #10b981; font-size: 1rem; font-weight: 600;">⚽ Голы:</h5>
                  <div class="points-list">
                    <div class="point-item p-2 mb-2 rounded" style="background: #f0fdf4; border-left: 3px solid #10b981;">
                      <strong>Дубль</strong> (2 гола): +0.3 × mod
                    </div>
                    <div class="point-item p-2 mb-2 rounded" style="background: #f0fdf4; border-left: 3px solid #10b981;">
                      <strong>Хет-трик</strong> (3 гола): +0.4 × mod
                    </div>
                    <div class="point-item p-2 mb-2 rounded" style="background: #f0fdf4; border-left: 3px solid #10b981;">
                      <strong>Покер</strong> (4+ гола): +0.7 × mod
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <h5 class="mb-2" style="color: #06b6d4; font-size: 1rem; font-weight: 600;">🎯 Ассисты:</h5>
                  <div class="points-list">
                    <div class="point-item p-2 mb-2 rounded" style="background: #ecfeff; border-left: 3px solid #06b6d4;">
                      <strong>Двойной пас</strong> (2 ассиста): +0.3 × mod
                    </div>
                    <div class="point-item p-2 mb-2 rounded" style="background: #ecfeff; border-left: 3px solid #06b6d4;">
                      <strong>Плеймейкер</strong> (3 ассиста): +0.4 × mod
                    </div>
                    <div class="point-item p-2 mb-2 rounded" style="background: #ecfeff; border-left: 3px solid #06b6d4;">
                      <strong>Маэстро</strong> (4+ ассиста): +0.7 × mod
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <h5 class="mb-2" style="color: #8b5cf6; font-size: 1rem; font-weight: 600;">🛡️ Сейвы:</h5>
                  <div class="points-list">
                    <div class="point-item p-2 mb-2 rounded" style="background: #faf5ff; border-left: 3px solid #8b5cf6;">
                      <strong>Стена</strong> (2 сейва): +0.2 × mod
                    </div>
                    <div class="point-item p-2 mb-2 rounded" style="background: #faf5ff; border-left: 3px solid #8b5cf6;">
                      <strong>Защитник</strong> (3 сейва): +0.3 × mod
                    </div>
                    <div class="point-item p-2 mb-2 rounded" style="background: #faf5ff; border-left: 3px solid #8b5cf6;">
                      <strong>Супер-вратарь</strong> (4+ сейва): +0.5 × mod
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <h5 class="mb-2" style="color: #f59e0b; font-size: 1rem; font-weight: 600;">🏆 Специальные:</h5>
                  <div class="points-list">
                    <div class="point-item p-2 mb-2 rounded" style="background: #fffbeb; border-left: 3px solid #f59e0b;">
                      <strong>"Сухарь"</strong> (есть сейвы и соперник не забил): +0.2 × mod
                    </div>
                  </div>
                </div>
                <div>
                  
                </div>
                <div class="mt-2 p-2 rounded" style="background: #f3f4f6; border-left: 3px solid #6b7280;">
                  <small class="text-muted"><strong>⚠️ Важно:</strong> Бонусы не суммируются — выбирается максимальный в каждой категории (Покер/Маэстро/Супер-вратарь 4+ > Хет-трик/Плеймейкер/Защитник 3 > Дубль/Двойной пас/Стена 2)</small>
                </div>
              </div>

              <div class="points-section mb-3">
                <h4 class="mb-2" style="color: #f59e0b; font-size: 1.1rem;">🏆 MVP награды:</h4>
                <p class="text-muted mb-2"><em>(НЕ умножается на mod)</em></p>
                <div class="points-list">
                  <div class="point-item p-2 mb-2 rounded" style="background: #fffbeb; border-left: 3px solid #f59e0b;">
                    <strong>MVP турнира:</strong> +1.0 к рейтингу
                  </div>
                  <div class="point-item p-2 mb-2 rounded" style="background: #fffbeb; border-left: 3px solid #f59e0b;">
                    <strong>MVP команды:</strong> +0.5 к рейтингу
                  </div>
                </div>
              </div>
            </div>

            <div class="rating-penalties mb-4">
              <h3 class="mb-3 d-flex align-items-center">
                <span style="font-size: 1.5rem; margin-right: 8px;">📉</span>
                <span>За что снимаются очки</span>
              </h3>
              <p class="text-muted mb-3"><em>(НЕ умножается на mod)</em></p>
              
              <div class="penalties-list">
                <div class="penalty-item p-2 mb-2 rounded" style="background: #fef2f2; border-left: 3px solid #ef4444;">
                  <strong>Поражение:</strong> −1.3
                </div>
                <div class="penalty-item p-2 mb-2 rounded" style="background: #fef2f2; border-left: 3px solid #ef4444;">
                  <strong>"Сухое поражение"</strong> (проиграли + соперник забил 3+ + ваша команда 0): −1.8
                </div>
              </div>

              <div class="penalty-mitigation mt-3 p-3 rounded" style="background: #fffbeb; border-left: 4px solid #f59e0b;">
                <h4 class="mb-2" style="font-size: 1rem; color: #d97706;">Смягчение штрафа при поражении:</h4>
                <p class="mb-2"><small class="text-muted"><strong>⚠️ Важно:</strong> Смягчение применяется только одно (максимальное):</small></p>
                <ul class="mb-0 ps-3">
                  <li>Если при поражении забил <strong>2+ гола</strong> → штраф уменьшается на <strong>0.5</strong></li>
                  <li>Иначе, если сделал <strong>2+ действий</strong> (голы + ассисты + сейвы) → штраф уменьшается на <strong>0.4</strong></li>
                </ul>
              </div>
            </div>

            <div class="rating-additional">
              <h3 class="mb-3 d-flex align-items-center">
                <span style="font-size: 1.5rem; margin-right: 8px;">🟨</span>
                <span>Дополнительно</span>
              </h3>
              <div class="additional-item p-2 rounded" style="background: #fefce8; border-left: 3px solid #eab308;">
                <strong>Жёлтая карточка:</strong> −0.3 (без mod)
              </div>
            </div>
          </div>
        </div>

        <!-- Таб Турнир -->
        <div class="tab-pane fade info-page__panel" id="tournament" role="tabpanel" aria-labelledby="tournament-tab">
          <div class="tournament-content">
            <div class="tournament-intro mb-4">
              <h2 class="mb-3 d-flex align-items-center">
                <span style="font-size: 1.5rem; margin-right: 8px;">🏆</span>
                <span>Турниры РФОИ</span>
              </h2>
              <p class="lead">Регулярные турниры с участием команд. Турниры проходят с судьями.</p>
            </div>

            <div class="tournament-online mb-4 p-3 p-md-4 rounded shadow-sm" role="region" aria-labelledby="tournament-online-heading" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 45%, #faf5ff 100%); border: 1px solid rgba(99, 102, 241, 0.35); border-left: 5px solid #6366f1;">
              <h3 class="mb-2 d-flex align-items-center flex-wrap gap-2" id="tournament-online-heading" style="font-size: 1.1rem; font-weight: 700; color: #312e81;">
                <span style="font-size: 1.25rem;" aria-hidden="true">📡</span>
                <span>Онлайн и итоги</span>
              </h3>
              <p class="mb-3 small mb-md-3" style="color: #3730a3;"><strong>tournament.pavelsolntsev.ru</strong> — ход турнира онлайн, итоги и архив.</p>
              <a class="btn text-white" style="background: #4f46e5; border-color: #4f46e5;" href="https://tournament.pavelsolntsev.ru/" target="_blank" rel="noopener noreferrer">Открыть</a>
            </div>

            <div class="tournament-vk-hint mb-4 p-3 p-md-4 rounded shadow-sm" role="region" aria-label="ВКонтакте для турниров" style="background: linear-gradient(135deg, #e8f4ff 0%, #dbeafe 100%); border: 1px solid rgba(39, 135, 245, 0.3); border-left: 5px solid #2787F5;">
              <strong class="d-flex align-items-center gap-2 mb-2" style="color: #1e3a5f;"><i class="fab fa-vk" style="color: #2787F5; font-size: 1.2rem;" aria-hidden="true"></i>ВКонтакте — анонсы и общение</strong>
              <p class="mb-3 small mb-md-3" style="color: #334155;">Подпишись на сообщество и зайди в чат: там объявляют турниры и договариваются команды.</p>
              <div class="d-flex flex-wrap gap-2">
                <a class="btn btn-primary btn-sm d-inline-flex align-items-center gap-2" style="background: #2787F5; border-color: #2787F5;" href="https://vk.com/rmsfootball" target="_blank" rel="noopener noreferrer"><i class="fab fa-vk" aria-hidden="true"></i>Сообщество</a>
                <a class="btn btn-sm d-inline-flex align-items-center gap-2" style="border: 2px solid #2787F5; color: #1856a8; background: #fff;" href="https://vk.me/join/D/st103iIqXvHn2Y2tU1H1mHa2tomwwydbw=" target="_blank" rel="noopener noreferrer"><i class="fab fa-vk" style="color: #2787F5;" aria-hidden="true"></i>Чат</a>
              </div>
            </div>

            <div class="tournament-format mb-4">
              <h3 class="mb-3">📋 Формат турнира:</h3>
              <div class="format-info p-3 rounded mb-3" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-left: 4px solid #3b82f6;">
                <ul class="mb-0 ps-3">
                  <li>Турнир из <strong>4 команд</strong></li>
                  <li>Игры в <strong>3 круга</strong></li>
                  <li>Длительность: <strong>2 часа</strong></li>
                  <li>Турниры проходят <strong>с судьями</strong></li>
                </ul>
              </div>
            </div>

            <div class="tournament-participation mb-4">
              <h3 class="mb-3 d-flex align-items-center">
                <span style="font-size: 1.5rem; margin-right: 8px;">📌</span>
                <span>Условия участия</span>
              </h3>
              <div class="participation-steps">
                <div class="step-item p-3 mb-2 rounded" style="background: #f0fdf4; border-left: 3px solid #10b981;">
                  <strong>1. Регистрация команды:</strong><br>
                  Капитан команды должен написать в <a class="d-inline-flex align-items-center gap-1" href="https://vk.com/rmsfootball" target="_blank" rel="noopener noreferrer"><i class="fab fa-vk" style="color: #2787F5;" aria-hidden="true"></i><span>сообщество ВКонтакте</span></a> или <a class="d-inline-flex align-items-center gap-1" href="https://vk.me/join/D/st103iIqXvHn2Y2tU1H1mHa2tomwwydbw=" target="_blank" rel="noopener noreferrer"><i class="fab fa-vk" style="color: #2787F5;" aria-hidden="true"></i><span>чат</span></a> после анонса турнира, указав название команды.
                </div>
                <div class="step-item p-3 mb-2 rounded" style="background: #f0fdf4; border-left: 3px solid #10b981;">
                  <strong>2. Бронирование слота:</strong><br>
                  Чтобы забронировать слот, необходимо внести взнос — <strong>5200 ₽ с команды</strong>.
                </div>
                <div class="step-item p-3 mb-2 rounded" style="background: #fef2f2; border-left: 3px solid #ef4444;">
                  <strong>⚠️ Важно:</strong> Если все места будут заняты, а команда не оплатила слот, её место может занять другая команда, внёсшая оплату, даже если она пока не в списке.
                </div>
              </div>
            </div>

            <div class="tournament-registration mb-4">
              <h3 class="mb-3 d-flex align-items-center">
                <span style="font-size: 1.5rem; margin-right: 8px;">📅</span>
                <span>Дополнительно</span>
              </h3>
              <div class="registration-info p-3 rounded mb-3" style="background: #fffbeb; border-left: 4px solid #f59e0b;">
                <ul class="mb-0 ps-3">
                  <li><i class="fab fa-telegram me-1" style="color: #229ed9;" aria-hidden="true"></i>В четверг перед турниром через бота будет открыта запись на турнир.</li>
                  <li>Всем участникам команд нужно будет записаться на матч через кнопку <strong>"Играть"</strong>.</li>
                  <li>Если игрок ещё не в сообществе, сначала <a class="d-inline-flex align-items-center gap-1" href="https://vk.com/rmsfootball" target="_blank" rel="noopener noreferrer"><i class="fab fa-vk" style="color: #2787F5;" aria-hidden="true"></i><span>подпишись</span></a> и при необходимости <a class="d-inline-flex align-items-center gap-1" href="https://vk.me/join/D/st103iIqXvHn2Y2tU1H1mHa2tomwwydbw=" target="_blank" rel="noopener noreferrer"><i class="fab fa-vk" style="color: #2787F5;" aria-hidden="true"></i><span>вступи в чат</span></a>, затем запишись на игру.</li>
                </ul>
              </div>
            </div>

            <div class="tournament-champion mb-4">
              <h3 class="mb-3 d-flex align-items-center">
                <span style="font-size: 1.5rem; margin-right: 8px;">👑</span>
                <span>Привилегии чемпиона</span>
              </h3>
              <div class="champion-info p-3 rounded mb-3" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-left: 4px solid #f59e0b;">
                <p class="mb-2"><strong>Чемпион турнира</strong> получает возможность <strong>вне очереди забронировать место</strong> на следующий турнир.</p>
                <p class="mb-0"><strong>⚠️ Важно:</strong> Капитан команды должен подтвердить участие до момента анонса. Если подтверждение не получено, команда сможет записаться только после 12:00, как и все остальные.</p>
              </div>
            </div>

            <div class="tournament-cards mb-4">
              <h3 class="mb-3 d-flex align-items-center">
                <span style="font-size: 1.5rem; margin-right: 8px;">🟨</span>
                <span>Правила карточек</span>
              </h3>
              <div class="cards-rules">
                <div class="card-rule-item p-3 mb-2 rounded" style="background: #fefce8; border-left: 3px solid #eab308;">
                  <strong>Жёлтая карточка:</strong><br>
                  Если игрок получает <strong>3 жёлтые карточки</strong>, он пропускает следующий турнир, а затем они сгорают.
                </div>
                <div class="card-rule-item p-3 mb-2 rounded" style="background: #fef2f2; border-left: 3px solid #ef4444;">
                  <strong>Красная карточка:</strong><br>
                  Если игрок получает красную карточку, он садится до конца текущего матча, далее может выйти на поле.
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Таб MVP -->
        <div class="tab-pane fade info-page__panel" id="mvp" role="tabpanel" aria-labelledby="mvp-tab">
          <div class="mvp-content">
            <div class="mvp-intro mb-4">
              <h2 class="mb-3 d-flex align-items-center">
                <span style="font-size: 1.5rem; margin-right: 8px;">⭐</span>
                <span>Как определяется MVP (лучший игрок)</span>
              </h2>
                <div class="mvp-description p-3 rounded mb-4" style="background: linear-gradient(135deg, #fff7ed 0%, #fed7aa 100%); border-left: 4px solid #f59e0b;">
                <p class="mb-2">В нашей системе выбираются <strong>MVP турнира</strong> (среди всех участников) и <strong>MVP каждой команды</strong>.</p>
                <p class="mb-0"><small class="text-muted">Учёт места команды в таблице (очки и разница мячей) используется только при выборе <strong>MVP турнира</strong>. Для <strong>MVP команды</strong> сравниваются только игроки одной команды, поэтому дальше сразу идут прирост рейтинга за турнир, карточки и остальные шаги.</small></p>
              </div>
            </div>

            <div class="mvp-bonuses mb-4">
              <h3 class="mb-3 d-flex align-items-center">
                <span style="font-size: 1.5rem; margin-right: 8px;">🎁</span>
                <span>Бонусы за MVP</span>
              </h3>
              <div class="bonuses-list">
                <div class="bonus-item p-3 mb-2 rounded" style="background: #fffbeb; border-left: 3px solid #f59e0b;">
                  <strong>MVP турнира</strong> — <span style="color: #f59e0b; font-weight: 600;">+1 очко к рейтингу</span> за турнир
                </div>
                <div class="bonus-item p-3 mb-2 rounded" style="background: #fef3c7; border-left: 3px solid #eab308;">
                  <strong>MVP команды</strong> — <span style="color: #d97706; font-weight: 600;">+0,5 очка к рейтингу</span> (если игрок уже не MVP турнира)
                </div>
                <p class="mb-0 mt-2"><small class="text-muted">В колонке «MVP» в таблице игроков накапливается только число званий <strong>MVP турнира</strong> (по +1 за каждый такой турнир). Звание MVP команды даёт только прибавку к рейтингу.</small></p>
              </div>
            </div>

            <div class="mvp-selection mb-4">
              <h3 class="mb-3 d-flex align-items-center">
                <span style="font-size: 1.5rem; margin-right: 8px;">📊</span>
                <span>Порядок выбора MVP</span>
              </h3>
              <p class="lead mb-3">Игроки сравниваются по правилам ниже. На каждом шаге выбирается лучший; при равенстве переходим к следующему критерию.</p>

              <!-- Критерий 1 -->
              <div class="mvp-criterion mb-3">
                <div class="criterion-header p-3 rounded-top" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
                  <h4 class="mb-1" style="font-size: 1.1rem; color: white;">
                    <strong>1. Результативные действия (метки)</strong>
                  </h4>
                </div>
                <div class="criterion-body p-3 rounded-bottom" style="background: #f0fdf4; border: 2px solid #10b981; border-top: none;">
                  <p class="mb-2">Считается «взвешенная» сумма действий:</p>
                  <ul class="mb-2 ps-3">
                    <li><strong>Гол = 1 очко</strong></li>
                    <li><strong>Ассист = 1 очко</strong></li>
                    <li><strong>Сейв = 0,75 очка</strong></li>
                  </ul>
                  <div class="formula p-2 rounded" style="background: rgba(16, 185, 129, 0.1); font-family: monospace;">
                    <strong>Формула:</strong> голы + ассисты + сейвы × 0,75
                  </div>
                  <p class="mb-0 mt-2"><small class="text-muted">Чем больше эта сумма, тем выше шанс стать MVP. Сейвы учитываются чуть слабее, чем голы и ассисты.</small></p>
                </div>
              </div>

              <!-- Критерии 2-4 -->
              <div class="mvp-criterion mb-3">
                <div class="criterion-compact p-3 mb-2 rounded" style="background: #eff6ff; border-left: 4px solid #3b82f6;">
                  <strong>2. При равенстве меток — по голам</strong><br>
                  <small>При равной сумме меток приоритет у игрока с большим числом голов.</small>
                </div>
                <div class="criterion-compact p-3 mb-2 rounded" style="background: #eff6ff; border-left: 4px solid #3b82f6;">
                  <strong>3. При равенстве голов — по ассистам</strong><br>
                  <small>Если и голов одинаково, сравниваются ассисты.</small>
                </div>
                <div class="criterion-compact p-3 mb-2 rounded" style="background: #eff6ff; border-left: 4px solid #3b82f6;">
                  <strong>4. При равенстве ассистов — по сейвам</strong><br>
                  <small>Если и ассистов одинаково, сравниваются сейвы.</small>
                </div>
              </div>

              <!-- Критерии 5-6 -->
              <div class="mvp-criterion mb-3">
                <div class="criterion-header p-3 rounded-top" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white;">
                  <h4 class="mb-1" style="font-size: 1.1rem; color: white;">
                    <strong>5. При равной статистике — очки команды</strong>
                  </h4>
                </div>
                <div class="criterion-body p-3 rounded-bottom" style="background: #faf5ff; border: 2px solid #8b5cf6; border-top: none;">
                  <p class="mb-0">При равной личной статистике приоритет у игрока, чья команда набрала больше очков (3 очка за победу, 1 за ничью). <small class="text-muted">Только для MVP турнира.</small></p>
                </div>
              </div>

              <div class="mvp-criterion mb-3">
                <div class="criterion-compact p-3 rounded" style="background: #faf5ff; border-left: 4px solid #8b5cf6;">
                  <strong>6. При равных очках команды — разница мячей</strong><br>
                  <small>Если очки команды одинаковы, приоритет у игрока из команды с лучшей разницей мячей (забитые минус пропущенные). Только для MVP турнира.</small>
                </div>
              </div>

              <!-- Критерии 7-11 -->
              <div class="mvp-criterion mb-3">
                <div class="criterion-compact p-3 mb-2 rounded" style="background: #ecfeff; border-left: 4px solid #06b6d4;">
                  <strong>7. Прирост рейтинга за турнир</strong><br>
                  <small>При равных показателях выше тот, у кого больше суммарная дельта рейтинга за турнир <strong>до</strong> бонусов MVP (+1 / +0,5).</small>
                </div>
                <div class="criterion-compact p-3 mb-2 rounded" style="background: #fefce8; border-left: 4px solid #eab308;">
                  <strong>8. Дисциплина — меньше жёлтых карточек</strong><br>
                  <small>При прочих равных приоритет у игрока без жёлтых карточек или с меньшим их числом.</small>
                </div>
                <div class="criterion-compact p-3 mb-2 rounded" style="background: #f0fdf4; border-left: 4px solid #10b981;">
                  <strong>9. Личные победы</strong><br>
                  <small>При равных условиях выше игрок, чья команда выиграла больше матчей в турнире, в которых он участвовал.</small>
                </div>
                <div class="criterion-compact p-3 mb-2 rounded" style="background: #f0f9ff; border-left: 4px solid #0ea5e9;">
                  <strong>10. Рейтинг на старте турнира</strong><br>
                  <small>Если всё совпадает, приоритет у игрока с более высоким рейтингом на старте турнира.</small>
                </div>
                <div class="criterion-compact p-3 rounded" style="background: #f3f4f6; border-left: 4px solid #6b7280;">
                  <strong>11. Итоговый выбор</strong><br>
                  <small>Если показатели полностью совпали — побеждает игрок с <strong>меньшим числовым id</strong> (детерминированно, без случайности).</small>
                </div>
              </div>
            </div>

            <div class="mvp-summary mb-4">
              <h3 class="mb-3 d-flex align-items-center">
                <span style="font-size: 1.5rem; margin-right: 8px;">📝</span>
                <span>Кратко</span>
              </h3>
              <div class="summary-info p-4 rounded" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-left: 4px solid #f59e0b;">
                <ul class="mb-0 ps-3">
                  <li class="mb-2"><strong>Голы и ассисты важнее сейвов</strong> (сейвы считаются с коэффициентом 0,75).</li>
                  <li class="mb-2"><strong>Личная статистика</strong> (голы, ассисты, сейвы) важнее всего.</li>
                  <li class="mb-2">Дополнительно учитываются <strong>успехи команды и дисциплина</strong>.</li>
                  <li class="mb-0"><strong>MVP турнира</strong> получает +1 к рейтингу, <strong>MVP команды</strong> — +0,5.</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const copyPhoneElement = document.querySelector('.copy-phone');
  
  if (copyPhoneElement) {
    const originalHTML = copyPhoneElement.innerHTML;
    
    copyPhoneElement.addEventListener('click', function() {
      const phone = this.getAttribute('data-phone');
      
      // Копируем номер в буфер обмена
      navigator.clipboard.writeText(phone).then(function() {
        // Показываем заметное сообщение об успехе
        copyPhoneElement.innerHTML = '<strong style="color: #10b981;"><i class="fas fa-check-circle"></i> Скопировано!</strong>';
        copyPhoneElement.style.background = 'rgba(16, 185, 129, 0.1)';
        copyPhoneElement.style.borderColor = '#10b981';
        
        setTimeout(function() {
          copyPhoneElement.innerHTML = originalHTML;
          copyPhoneElement.style.background = '';
          copyPhoneElement.style.borderColor = '';
        }, 2000);
      }).catch(function(err) {
        // Fallback для старых браузеров
        const textArea = document.createElement('textarea');
        textArea.value = phone;
        textArea.style.position = 'fixed';
        textArea.style.opacity = '0';
        document.body.appendChild(textArea);
        textArea.select();
        try {
          document.execCommand('copy');
          copyPhoneElement.innerHTML = '<strong style="color: #10b981;"><i class="fas fa-check-circle"></i> Скопировано!</strong>';
          copyPhoneElement.style.background = 'rgba(16, 185, 129, 0.1)';
          copyPhoneElement.style.borderColor = '#10b981';
          setTimeout(function() {
            copyPhoneElement.innerHTML = originalHTML;
            copyPhoneElement.style.background = '';
            copyPhoneElement.style.borderColor = '';
          }, 2000);
        } catch (err) {
          console.error('Не удалось скопировать номер', err);
          copyPhoneElement.innerHTML = '<strong style="color: #ef4444;">Ошибка копирования</strong>';
          setTimeout(function() {
            copyPhoneElement.innerHTML = originalHTML;
          }, 2000);
        }
        document.body.removeChild(textArea);
      });
    });
  }
});
</script>
