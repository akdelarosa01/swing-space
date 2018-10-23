<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => '该 :attribute 必须接受。',
    'active_url'           => '该 :attribute 不是有效的URL。',
    'after'                => '该 :attribute 必须是之后的约会 :date.',
    'after_or_equal'       => '该 :attribute 必须经过的日期或等于日期 :date.',
    'alpha'                => '该 :attribute 可能只包含字母。',
    'alpha_dash'           => '该 :attribute 可能只包含字母，数字，短划线和下划线。',
    'alpha_num'            => '该 :attribute 可能只包含字母和数字。',
    'array'                => '该 :attribute 必须是一个数组。',
    'before'               => '该 :attribute 必须是日期之前的日期 :date.',
    'before_or_equal'      => '该 :attribute 必须是日期之前或等于日期 :date.',
    'between'              => [
        'numeric' => '该 :attribute 必须在之间 :min 而 :max.',
        'file'    => '该 :attribute 必须在之间 :min 而 :max 千字节为单位。',
        'string'  => '该 :attribute 必须在之间 :min 而 :max 人物。',
        'array'   => '该 :attribute 必须介于 :min 而 :max 项。',
    ],
    'boolean'              => '该 :attribute 字段必须是真或假。',
    'confirmed'            => '该 :attribute 确认不符合。',
    'date'                 => '该 :attribute 不是有效日期。',
    'date_format'          => '该 :attribute 与格式不匹配 :format.',
    'different'            => '该 :attribute 而 :other 必须是不同的。',
    'digits'               => '该 :attribute 必须是 :digits 数位.',
    'digits_between'       => '该 :attribute 必须在之间 :min 而 :max 数位。',
    'dimensions'           => '该 :attribute 具有无效的图像尺寸。',
    'distinct'             => '该 :attribute 字段具有重复值。',
    'email'                => '该 :attribute 必须是有效的电子邮件地址。',
    'exists'               => '该 选 :attribute 是无效的。',
    'file'                 => '该 :attribute 必须是一个文件。',
    'filled'               => '该 :attribute 字段必须具有值。',
    'gt'                   => [
        'numeric' => '该 :attribute 必须大于 :value.',
        'file'    => '该 :attribute 必须大于 :value 千字节为单位。',
        'string'  => '该 :attribute 必须大于 :value 人物。',
        'array'   => '该 :attribute 必须有超过 :value 项。',
    ],
    'gte'                  => [
        'numeric' => '该 :attribute 必须大于或等于 :value.',
        'file'    => '该 :attribute 必须大于或等于 :value 千字节为单位。',
        'string'  => '该 :attribute 必须大于或等于 :value 人物。',
        'array'   => '该 :attribute 一定有 :value 项 或者更多。',
    ],
    'image'                => '该 :attribute 必须是一个形象。',
    'in'                   => '该 选 :attribute 是无效的。',
    'in_array'             => '该 :attribute 字段不存在于 :other。',
    'integer'              => '该 :attribute 必须是整数。',
    'ip'                   => '该 :attribute 必须是一个有效的IP地址。',
    'ipv4'                 => '该 :attribute 必须是有效的IPv4地址。',
    'ipv6'                 => '该 :attribute 必须是一个有效的IPv6地址。',
    'json'                 => '该 :attribute 必须是有效的JSON字符串。',
    'lt'                   => [
        'numeric' => '该 :attribute 必须小于 :value。',
        'file'    => '该 :attribute 必须小于 :value 千字节为单位。',
        'string'  => '该 :attribute 必须小于 :value 人物。',
        'array'   => '该 :attribute 必须少于 :value 项。',
    ],
    'lte'                  => [
        'numeric' => '该 :attribute 必须小于或等于 :value。',
        'file'    => '该 :attribute 必须小于或等于 :value 千字节为单位。',
        'string'  => '该 :attribute 必须小于或等于 :value 人物。',
        'array'   => '该 :attribute 一定不能超过 :value 项。',
    ],
    'max'                  => [
        'numeric' => '该 :attribute 可能不会大于 :max。',
        'file'    => '该 :attribute 可能不会大于 :max 千字节为单位。',
        'string'  => '该 :attribute 可能不会大于 :max 人物。',
        'array'   => '该 :attribute 可能不会超过 :max 项。',
    ],
    'mimes'                => '该 :attribute 必须是类型的文件: :values。',
    'mimetypes'            => '该 :attribute 必须是类型的文件: :values。',
    'min'                  => [
        'numeric' => '该 :attribute 必须至少 :min。',
        'file'    => '该 :attribute 必须至少 :min 千字节为单位。',
        'string'  => '该 :attribute 必须至少 :min 人物。',
        'array'   => '该 :attribute 必须至少有 :min 项。',
    ],
    'not_in'               => '该 选 :attribute 是无效的。',
    'not_regex'            => '该 :attribute 格式 是无效的。',
    'numeric'              => '该 :attribute 必须是一个数字。',
    'present'              => '该 :attribute 必须在场。',
    'regex'                => '该 :attribute 格式 是无效的。',
    'required'             => '该 :attribute 字段是必需的。',
    'required_if'          => '该 :attribute 字段是必须的，如果 :other 就是 :value。',
    'required_unless'      => '该 :attribute 字段是必需的，除非 :other 就是 在 :values。',
    'required_with'        => '该 :attribute 字段是必须的，如果 :values 存在。',
    'required_with_all'    => '该 :attribute 字段是必须的，如果 :values 存在。',
    'required_without'     => '该 :attribute 字段是必须的，如果 :values 不存在。',
    'required_without_all' => '该 :attribute 如果没有 :values，则需要字段。',
    'same'                 => '该 :attribute 而 :other 必须匹配。',
    'size'                 => [
        'numeric' => '该 :attribute 必须是 :size。',
        'file'    => '该 :attribute 必须是 :size 千字节为单位。',
        'string'  => '该 :attribute 必须是 :size 人物。',
        'array'   => '该 :attribute 必须包含 :size 项。',
    ],
    'string'               => '该 :attribute 必须是一个字符串。',
    'timezone'             => '该 :attribute 必须是有效的时区。',
    'unique'               => '该 :attribute 已有人带走了。',
    'uploaded'             => '该 :attribute 无法上传。',
    'url'                  => '该 :attribute 格式 是无效的。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
