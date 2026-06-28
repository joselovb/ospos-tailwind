<?php
/**
 * @var object $person_info
 * @var array $config
 */
?>

<div class="form-group sm:flex sm:items-start sm:gap-4">
    <?= form_label(lang('Common.first_name'), 'first_name', ['class' => 'required ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
    <div>
        <?= form_input([
            'name'  => 'first_name',
            'id'    => 'first_name',
            'class' => 'ui-input',
            'value' => $person_info->first_name
        ]) ?>
    </div>
</div>

<div class="form-group sm:flex sm:items-start sm:gap-4">
    <?= form_label(lang('Common.last_name'), 'last_name', ['class' => 'required ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
    <div>
        <?= form_input([
            'name'  => 'last_name',
            'id'    => 'last_name',
            'class' => 'ui-input',
            'value' => $person_info->last_name
        ]) ?>
    </div>
</div>

<div class="form-group sm:flex sm:items-start sm:gap-4">
    <?= form_label(lang('Common.gender'), 'gender', !empty($basic_version) ? ['class' => 'required ui-label sm:w-40 sm:shrink-0 sm:pt-2'] : ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2']) ?>
    <div class="flex flex-wrap items-center gap-x-4 gap-y-2 pt-2">
        <label class="radio-inline flex items-center gap-2 text-sm text-text-default">
            <?= form_radio([
                'name'    => 'gender',
                'type'    => 'radio',
                'id'      => 'gender',
                'value'   => 1,
                'checked' => $person_info->gender === '1'
            ]) ?> <?= lang('Common.gender_male') ?>
        </label>
        <label class="radio-inline flex items-center gap-2 text-sm text-text-default">
            <?= form_radio([
                'name'    => 'gender',
                'type'    => 'radio',
                'id'      => 'gender',
                'value'   => 0,
                'checked' => $person_info->gender === '0'
            ]) ?> <?= lang('Common.gender_female') ?>
        </label>
    </div>
</div>

<div class="form-group sm:flex sm:items-start sm:gap-4">
    <?= form_label(lang('Common.email'), 'email', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
    <div class="relative">
        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-text-muted">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </span>
        <?= form_input([
            'name'  => 'email',
            'id'    => 'email',
            'class' => 'ui-input pr-10',
            'value' => $person_info->email
        ]) ?>
    </div>
</div>

<div class="form-group sm:flex sm:items-start sm:gap-4">
    <?= form_label(lang('Common.phone_number'), 'phone_number', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
    <div class="relative">
        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-text-muted">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.19 2 2 0 0 1 3.59 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        </span>
        <?= form_input([
            'name'  => 'phone_number',
            'id'    => 'phone_number',
            'class' => 'ui-input pr-10',
            'value' => $person_info->phone_number
        ]) ?>
    </div>
</div>

<div class="form-group sm:flex sm:items-start sm:gap-4">
    <?= form_label(lang('Common.address_1'), 'address_1', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
    <div>
        <?= form_input([
            'name'  => 'address_1',
            'id'    => 'address_1',
            'class' => 'ui-input',
            'value' => $person_info->address_1
        ]) ?>
    </div>
</div>

<div class="form-group sm:flex sm:items-start sm:gap-4">
    <?= form_label(lang('Common.address_2'), 'address_2', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
    <div>
        <?= form_input([
            'name'  => 'address_2',
            'id'    => 'address_2',
            'class' => 'ui-input',
            'value' => $person_info->address_2
        ]) ?>
    </div>
</div>

<div class="form-group sm:flex sm:items-start sm:gap-4">
    <?= form_label(lang('Common.city'), 'city', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
    <div>
        <?= form_input([
            'name'  => 'city',
            'id'    => 'city',
            'class' => 'ui-input',
            'value' => $person_info->city
        ]) ?>
    </div>
</div>

<div class="form-group sm:flex sm:items-start sm:gap-4">
    <?= form_label(lang('Common.state'), 'state', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
    <div>
        <?= form_input([
            'name'  => 'state',
            'id'    => 'state',
            'class' => 'ui-input',
            'value' => $person_info->state
        ]) ?>
    </div>
</div>

<div class="form-group sm:flex sm:items-start sm:gap-4">
    <?= form_label(lang('Common.zip'), 'zip', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
    <div class="max-w-40">
        <?= form_input([
            'name'  => 'zip',
            'id'    => 'postcode',
            'class' => 'ui-input',
            'value' => $person_info->zip
        ]) ?>
    </div>
</div>

<div class="form-group sm:flex sm:items-start sm:gap-4">
    <?= form_label(lang('Common.country'), 'country', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
    <div>
        <?= form_input([
            'name'  => 'country',
            'id'    => 'country',
            'class' => 'ui-input',
            'value' => $person_info->country
        ]) ?>
    </div>
</div>

<div class="form-group sm:flex sm:items-start sm:gap-4">
    <?= form_label(lang('Common.comments'), 'comments', ['class' => 'ui-label sm:w-40 sm:shrink-0 sm:pt-2.5']) ?>
    <div>
        <?= form_textarea([
            'name'  => 'comments',
            'id'    => 'comments',
            'class' => 'ui-input',
            'value' => $person_info->comments
        ]) ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        nominatim.init({
            fields: {
                postcode: {
                    dependencies: ["postcode", "city", "state", "country"],
                    response: {
                        field: 'postalcode',
                        format: ["postcode", "village|town|hamlet|city_district|city", "state", "country"]
                    }
                },

                city: {
                    dependencies: ["postcode", "city", "state", "country"],
                    response: {
                        format: ["postcode", "village|town|hamlet|city_district|city", "state", "country"]
                    }
                },

                state: {
                    dependencies: ["state", "country"]
                },

                country: {
                    dependencies: ["state", "country"]
                }
            },
            language: '<?= current_language_code() ?>',
            country_codes: '<?= esc($config['country_codes'], 'js') ?>'
        });
    });
</script>
