<footer class="site-footer">
  <div class="site-footer__inner">

    <?php $isHome = (strtok($_SERVER['REQUEST_URI'], '?') === '/'); ?>
    <?php if (!$isHome): ?><a href="/" class="site-footer__brand"><?php else: ?><div class="site-footer__brand"><?php endif; ?>
      <img src="img/main/logorfoi.webp" alt="РФОИ" class="site-footer__brand-logo">
      <span class="site-footer__brand-text">РФОИ</span>
    <?php if (!$isHome): ?></a><?php else: ?></div><?php endif; ?>

    <nav class="site-footer__nav">
      <a href="/">Главная</a>
      <?php if (strpos($_SERVER['REQUEST_URI'], '/tournament') !== false): ?>
        <a href="/">Игроки</a>
      <?php else: ?>
        <a href="/tournament/">Команды</a>
      <?php endif; ?>
      <a href="/2025/">Сезон 2025</a>
      <a href="/info/">Информация</a>
      <a href="https://tournament.pavelsolntsev.ru" target="_blank" rel="noopener noreferrer">
        <i class="fas fa-trophy" aria-hidden="true"></i> Турниры онлайн
      </a>
    </nav>

    <div class="site-footer__social">
      <a href="https://t.me/RmsFootball" target="_blank" rel="noopener noreferrer" title="Telegram РФОИ">
        <i class="fab fa-telegram" aria-hidden="true"></i> Telegram
      </a>
      <a href="https://vk.com/rmsfootball" target="_blank" rel="noopener noreferrer" title="ВКонтакте РФОИ">
        <i class="fab fa-vk" aria-hidden="true"></i> ВКонтакте
      </a>
    </div>

    <div class="site-footer__seo">
      <p class="site-footer__seo-text">Любительский футбол в Раменском — статистика игроков, результаты турниров, составы команд. Открытые игры каждый понедельник на Профилактории и турниры по пятницам на Красном Знамя.</p>
    </div>

    <div class="site-footer__copy">© <?= date('Y') ?> РФОИ — Раменское Футбол Открытые Игры</div>

  </div>
</footer>
