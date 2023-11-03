<?php

use app\modules\directory\models\QuestionsAnswer;

?>
<section class="service section section--pb-100">
    <div class="container">

        <?php if($questions = QuestionsAnswer::find()->orderBy(['sortOrder' => SORT_ASC])->all()) : ?>
                <section class="faq section">
                <div class="container">
                    <div class="faq__wrap">
                        <?php foreach($questions as $question) : ?>
                            <div class="faq__item">
                                <button class="faq__question js_accordion-control" type="button" aria-expanded="false">
                                    <p class="faq__question-text">
                                        <?= $question->question ?>
                                    </p>
                                    <span class="faq__question-icon"></span>
                                </button>
                                <article class="faq__answer js_accordion-content" aria-hidden="true">
                                    <p>
                                        <?= $question->answer ?>
                                    </p>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="faq__info">
                        <p class="faq__info-title">Не нашли ответ на свой вопрос?</p>
                        <p class="faq__info-text">
                            позвоните нам по телефону <a href="tel:+78129344554">+7 812 934-45-54</a>
                        </p>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </div>
</section>
