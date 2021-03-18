<section class="lot-item container">
    <h2><?= htmlspecialchars($lot['name']) ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= $lot['img_path'] ?>" width="730" height="548" alt="<?= $lot['name'] ?>">
            </div>
            <p class="lot-item__category">Категория: <span><?= $lot['category'] ?></span></p>
            <p class="lot-item__description"><?= htmlspecialchars($lot['description']) ?? '' ?></p>
        </div>
        <div class="lot-item__right">
            <?php if (isset($_SESSION['user'])): ?>
                <div class="lot-item__state">
                    <div class="lot-item__timer timer">
                        <?= getLastTime($lot['finish_date'], true) ?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?= formatPrice($lot['current_price']) ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?= isset($lot['price_step']) ? formatPrice($lot['current_price'] + $lot['price_step']) : formatPrice($lot['current_price']) ?></span>
                        </div>
                    </div>
                    <form class="lot-item__form" action="lot.php?id=<?= $lotId ?>" method="post">
                        <p class="lot-item__form-item <?= $error ? 'form__item--invalid' : '' ?>">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="bet_price" placeholder="<?= isset($lot['price_step']) ? number_format($lot['current_price'] + $lot['price_step'], 0, '', ' ') : number_format($lot['current_price'], 0, '', ' ') ?>" value="<?= $cost['bet_price'] ?? '' ?>">
                            <span class="form__error"><?= $error ?></span>
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                </div>
            <?php endif; ?>
            <div class="history">
                <h3>История ставок (<span><?= count($bets) ?></span>)</h3>
                <table class="history__list">
                    <?php foreach($bets as $bet): ?>
                        <tr class="history__item">
                            <td class="history__name"><?= $bet['name'] ?></td>
                            <td class="history__price"><?= formatPrice($bet['bet_price']) ?></td>
                            <td class="history__time"><?= date('m.d.y в H:i', strtotime($bet['bet_date'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>
