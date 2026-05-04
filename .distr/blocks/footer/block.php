<footer class="site-footer">
  <div class="site-footer__inner">
    <a href="/" class="site-footer__brand" title="На главную">
      <span class="site-footer__logo-icon"><i class="fas fa-futbol"></i></span>
      <span class="site-footer__logo-text">РФОИ</span>
    </a>
    <nav class="site-footer__nav">
      <a href="/info/">Информация</a>
      <a href="/">Главная</a>
      <?php if (strpos($_SERVER['REQUEST_URI'], '/tournament') !== false): ?>
        <a href="/">Игроки</a>
      <?php else: ?>
        <a href="/tournament/">Команды</a>
      <?php endif; ?>
      <a href="https://tournament.pavelsolntsev.ru" target="_blank" rel="noopener noreferrer" title="Турниры РФОИ — управление и результаты"><i class="fas fa-trophy" aria-hidden="true"></i><span> Турниры онлайн</span></a>
      <a href="https://t.me/RmsFootball" target="_blank" rel="noopener noreferrer" class="site-footer__tg" title="РФОИ в Telegram"><i class="fab fa-telegram" aria-hidden="true"></i><span> Telegram · РФОИ</span></a>
      <a href="https://vk.com/rmsfootball" target="_blank" rel="noopener noreferrer" class="site-footer__vk" title="РФОИ ВКонтакте"><i class="fab fa-vk" aria-hidden="true"></i><span> ВКонтакте · РФОИ</span></a>
    </nav>
    <div class="site-footer__seo">
      <h2 class="site-footer__seo-title">РФОИ — Раменское Футбол | Открытые Игры</h2>
      <p class="site-footer__seo-text">Любительский футбол в Раменском (Московская область) — статистика игроков, результаты турниров, составы команд. Открытые игры для всех желающих каждый понедельник на Профилактории и турниры каждую пятницу на Красном Знамя.</p>
    </div>
    <div class="site-footer__copy">© <?= date('Y') ?> Раменское футбол</div>
  </div>
</footer>
