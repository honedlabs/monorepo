<?php

use Conquest\Core\Field;

it('coalesces naming convention', function () {
    expect(Field::File->coalesced())->toBe('file');
    expect(Field::Title->coalesced())->toBe('title');
    expect(Field::Notes->coalesced())->toBe('details');
    expect(Field::Priority->coalesced())->toBe('order');
    expect(Field::Lat->coalesced())->toBe('latitude');
    expect(Field::Long->coalesced())->toBe('longitude');
    expect(Field::Colour->coalesced())->toBe('color');
    expect(Field::Name->coalesced())->toBeNull();
});

it('has a blueprint for migrations', function () {
    expect(Field::Name->blueprint('name'))->toBe('$table->string(\'name\');');
    expect(Field::Email->blueprint('email'))->toBe('$table->string(\'email\')->unique();');
    expect(Field::Slug->blueprint('slug'))->toBe('$table->string(\'slug\')->unique();');
    expect(Field::Description->blueprint('description'))->toBe('$table->string(\'description\', 512)->nullable();');
    expect(Field::Status->blueprint('status'))->toBe('$table->unsignedTinyInteger(\'status\')->default(0);');
    expect(Field::Color->blueprint('color'))->toBe('$table->string(\'color\')->default(\'#000000\');');
    expect(Field::Path->blueprint('path'))->toBe('$table->string(\'path\');');
    expect(Field::ForeignId->blueprint('user_id'))->toBe('$table->foreignId(\'user_id\')->constrained()->onDelete(\'cascade\');');
    expect(Field::StartsAt->blueprint('starts_at'))->toBe('$table->dateTime(\'starts_at\');');
    expect(Field::EndsAt->blueprint('ends_at'))->toBe('$table->dateTime(\'ends_at\')->nullable();');
    expect(Field::IsBoolean->blueprint('is_active'))->toBe('$table->boolean(\'is_active\')->default(false);');
    expect(Field::Details->blueprint('details'))->toBe('$table->text(\'details\')->nullable();');
    expect(Field::Data->blueprint('data'))->toBe('$table->json(\'data\')->nullable();');
    expect(Field::Phone->blueprint('phone'))->toBe('$table->string(\'phone\');');
    expect(Field::Price->blueprint('price'))->toBe('$table->unsignedInteger(\'price\')');
    expect(Field::Quantity->blueprint('quantity'))->toBe('$table->integer(\'quantity\')');
    expect(Field::Country->blueprint('country'))->toBe('$table->string(\'country\');');
    expect(Field::Duration->blueprint('duration'))->toBe('$table->unsignedInteger(\'duration\');');
    expect(Field::Minutes->blueprint('minutes'))->toBe('$table->unsignedInteger(\'minutes\');');
    expect(Field::Uuid->blueprint('uuid'))->toBe('$table->uuid(\'uuid\');');
    expect(Field::Order->blueprint('order'))->toBe('$table->unsignedSmallInteger(\'order\');');
    expect(Field::Coordinate->blueprint('coordinate'))->toBe('$table->point(\'coordinate\')');
    expect(Field::Latitude->blueprint('latitude'))->toBe('$table->decimal(\'latitude\', 10, 8)');
    expect(Field::Longitude->blueprint('longitude'))->toBe('$table->decimal(\'longitude\', 11, 8)');
    expect(Field::Version->blueprint('version'))->toBe('$table->unsignedSmallInteger(\'version\')');
    expect(Field::CreatedBy->blueprint('created_by'))->toBe('$table->foreignId(\'created_by\')->nullable()->constrained(\'users\')->onDelete(\'cascade\');');
    expect(Field::UpdatedBy->blueprint('updated_by'))->toBe('$table->foreignId(\'updated_by\')->nullable()->constrained(\'users\')->onDelete(\'cascade\');');
    expect(Field::Undefined->blueprint('other'))->toBe('$table->string(\'other\');');
});

it('specifies a length of the data type', function () {
    expect(Field::Status->length())->toBe(255);
    expect(Field::Description->length())->toBe(512);
    expect(Field::Order->length())->toBe(65535);
    expect(Field::Data->length())->toBe(16777215);
    expect(Field::Quantity->length())->toBe(2147483647);
    expect(Field::Price->length())->toBe(4294967295);
    expect(Field::Undefined->length())->toBe(0);
});

it('has rules for requests', function () {
    expect(Field::Email->rules('email', 'users'))->toBe('[\'required\', \'email\', max:255]');
    expect(Field::Slug->rules('slug', 'posts'))->toBe('[\'required\', \'string\', \'lowercase\', unique:posts,slug, max:255]');
    expect(Field::Password->rules('password'))->toBe('[\'required\', \'string\', \'min:8\', max:255]');
    expect(Field::Description->rules('description'))->toBe('[\'nullable\', \'string\', max:512]');
    expect(Field::Status->rules('status'))->toBe('[\'required\', \'integer\', \'min:0\', max:255]');
    expect(Field::Color->rules('color'))->toBe('[\'nullable\', \'hex_color\', max:255]');
    expect(Field::ForeignId->rules('user_id'))->toBe('[\'required\', \'integer\', exists:users,id]');
    expect(Field::StartsAt->rules('starts_at'))->toBe('[\'required\', \'date\', \'after_or_equal:now\']');
    expect(Field::EndsAt->rules('ends_at'))->toBe('[\'nullable\', \'date\', \'after_or_equal:now\']');
    expect(Field::IsBoolean->rules('is_active'))->toBe('[\'required\', \'boolean\']');
    expect(Field::Details->rules('details'))->toBe('[\'nullable\', \'string\', max:65535]');
    expect(Field::Data->rules('data'))->toBe('[\'required\', \'json\', max:16777215]');
    expect(Field::Price->rules('price'))->toBe('[\'required\', \'integer\', \'min:0\', max:4294967295]');
    expect(Field::Quantity->rules('quantity'))->toBe('[\'required\', \'integer\', \'min:0\', max:2147483647]');
    expect(Field::Uuid->rules('uuid'))->toBe('[\'required\', \'uuid\']');
    expect(Field::Order->rules('order'))->toBe('[\'required\', \'integer\', \'min:0\', max:65535]');
    expect(Field::Token->rules('token'))->toBe('[\'required\', \'alpha_num\', max:255]');
    expect(Field::Coordinate->rules('coordinate'))->toBe('[\'required\', \'point\']');
    expect(Field::Latitude->rules('latitude'))->toBe('[\'required\', \'decimal\', \'min:-90\', \'max:90\']');
    expect(Field::Longitude->rules('longitude'))->toBe('[\'required\', \'decimal\', \'min:-180\', \'max:180\']');
    expect(Field::Version->rules('version'))->toBe('[\'required\', \'integer\', \'min:0\', max:65535]');
    expect(Field::IpAddress->rules('ip_address'))->toBe('[\'required\', \'ip\']');
    expect(Field::Undefined->rules('undefined'))->toBe('[\'required\']');
    expect(Field::Url->rules('url'))->toBe('[\'required\', \'url\', max:512]');
    expect(Field::Name->rules('name'))->toBe('[\'required\', \'string\', max:255]');
});

it('has casts', function () {
    expect(Field::StartsAt->cast())->toBe('\'datetime\'');
    expect(Field::EndsAt->cast())->toBe('\'datetime\'');
    expect(Field::Data->cast())->toBe('\'json\'');
    expect(Field::Name->cast())->toBeNull();
});

it('can specify as hidden', function () {
    expect(Field::ForeignId->hidden())->toBeTrue();
    expect(Field::CreatedBy->hidden())->toBeTrue();
    expect(Field::UpdatedBy->hidden())->toBeTrue();
    expect(Field::Password->hidden())->toBeTrue();
    expect(Field::Token->hidden())->toBeTrue();
    expect(Field::Name->hidden())->toBeFalse();
});

it('has factories', function () {
    expect(Field::Name->factory())->toBe('fake()->name()');
    expect(Field::Email->factory())->toBe('fake()->unique()->safeEmail()');
    expect(Field::Slug->factory())->toBe('fake()->unique()->slug()');
    expect(Field::Password->factory())->toBe('fake()->password(8)');
    expect(Field::Username->factory())->toBe('fake()->unique()->userName()');
    expect(Field::FirstName->factory())->toBe('fake()->firstName()');
    expect(Field::LastName->factory())->toBe('fake()->lastName()');
    expect(Field::Description->factory())->toBe('fake()->text(512)');
    expect(Field::Status->factory())->toBe('fake()->numberBetween(0, 6)');
    expect(Field::Color->factory())->toBe('fake()->hexColor()');
    expect(Field::Code->factory())->toBe('fake()->unique()->regexify(\'[A-Z0-9]{5}\')');
    expect(Field::Path->factory())->toBe('fake()->filePath()');
    expect(Field::StartsAt->factory())->toBe('fake()->dateTimeBetween(\'-1 year\', \'now\')');
    expect(Field::EndsAt->factory())->toBe('fake()->dateTimeBetween(\'now\', \'+1 year\')');
    expect(Field::IsBoolean->factory())->toBe('fake()->boolean()');
    expect(Field::Details->factory())->toBe('fake()->text(65535)');
    expect(Field::Data->factory())->toBe('fake()->json()');
    expect(Field::Phone->factory())->toBe('fake()->phoneNumber()');
    expect(Field::Price->factory())->toBe('fake()->numberBetween(0, 10000)');
    expect(Field::Quantity->factory())->toBe('fake()->numberBetween(0, 1000000)');
    expect(Field::Address->factory())->toBe('fake()->address()');
    expect(Field::City->factory())->toBe('fake()->city()');
    expect(Field::State->factory())->toBe('fake()->state()');
    expect(Field::Zip->factory())->toBe('fake()->postcode()');
    expect(Field::Country->factory())->toBe('fake()->country()');
    expect(Field::Duration->factory())->toBe('fake()->numberBetween(0, 300)');
    expect(Field::Minutes->factory())->toBe('fake()->numberBetween(0, 300)');
    expect(Field::Uuid->factory())->toBe('fake()->uuid()');
    expect(Field::Order->factory())->toBe('fake()->numberBetween(0, 100)');
    expect(Field::Token->factory())->toBe('fake()->regexify(\'[A-Z0-9]{32}\')');
    expect(Field::Coordinate->factory())->toBe('fake()->point()');
    expect(Field::Latitude->factory())->toBe('fake()->latitude()');
    expect(Field::Longitude->factory())->toBe('fake()->longitude()');
    expect(Field::Version->factory())->toBe('fake()->numberBetween(0, 100)');
    expect(Field::Image->factory())->toBe('fake()->imageUrl()');
    expect(Field::Url->factory())->toBe('fake()->url()');
    expect(Field::IpAddress->factory())->toBe('fake()->ipv4()');
    expect(Field::Icon->factory())->toBe('fake()->slug()');
    expect(Field::ForeignId->factory())->toBe('null');
});

it('has relationships', function () {
    expect(Field::ForeignId->hasRelationship())->toBeTrue();
    expect(Field::CreatedBy->hasRelationship())->toBeTrue();
    expect(Field::UpdatedBy->hasRelationship())->toBeTrue();
    expect(Field::Name->hasRelationship())->toBeFalse();
});

it('can be undefined', function () {
    expect(Field::Undefined->isUndefined())->toBeTrue();
    expect(Field::Name->isUndefined())->toBeFalse();
});

it('retrieves fields using pattern matching', function () {
    expect(Field::tryWithPatterns('user_id'))->toBe(Field::ForeignId);
    expect(Field::tryWithPatterns('is_active'))->toBe(Field::IsBoolean);
    expect(Field::tryWithPatterns('name'))->toBe(Field::Name);
    expect(Field::tryWithPatterns('undefined'))->toBe(Field::Undefined);
});

it('can be internal', function () {
    expect(Field::Uuid->internal())->toBeTrue();
    expect(Field::CreatedBy->internal())->toBeTrue();
    expect(Field::UpdatedBy->internal())->toBeTrue();
    expect(Field::Name->internal())->toBeFalse();
});

it('has order precedence', function () {
    expect(Field::ForeignId->precedence())->toBe(2);
    expect(Field::Email->precedence())->toBe(1);
    expect(Field::Title->precedence())->toBe(1);
    expect(Field::Name->precedence())->toBe(1);
    expect(Field::Slug->precedence())->toBe(1);
    expect(Field::CreatedBy->precedence())->toBe(-1);
    expect(Field::UpdatedBy->precedence())->toBe(-1);
    expect(Field::Description->precedence())->toBe(0);
});

it('has relationship signatures', function () {
    expect(Field::ForeignId->relationship('user_id'))->toBe('public function user()
            {
                return $this->belongsTo(User::class);
            }
            ');
    expect(Field::ForeignId->relationship('user_id', 'posts'))->toBe('public function posts()
            {
                return $this->hasMany(Post::class);
            }
            ');
    expect(Field::CreatedBy->relationship('created_by'))->toBe('public function creator()
            {
                return $this->belongsTo(User::class);
            }
            ');
    expect(Field::UpdatedBy->relationship('updated_by'))->toBe('public function updater()
            {
                return $this->belongsTo(User::class);
            }
            ');
    expect(Field::Name->relationship('name'))->toBeNull();
});

it('generates data pairs', function () {
    expect(Field::dataPair('name'))->toBe(['name', Field::Name]);
    expect(Field::dataPair('user_id'))->toBe(['user_id', Field::ForeignId]);
    expect(Field::dataPair('is_active'))->toBe(['is_active', Field::IsBoolean]);
    expect(Field::dataPair('undefined'))->toBe(['undefined', Field::Undefined]);
});

it('has types', function () {
    expect(Field::Price->type())->toBe('numeric');
    expect(Field::Quantity->type())->toBe('numeric');
    expect(Field::Duration->type())->toBe('numeric');
    expect(Field::Minutes->type())->toBe('numeric');
    expect(Field::Order->type())->toBe('numeric');
    expect(Field::Priority->type())->toBe('numeric');
    expect(Field::Version->type())->toBe('numeric');
    expect(Field::StartsAt->type())->toBe('date');
    expect(Field::EndsAt->type())->toBe('date');
    expect(Field::IsBoolean->type())->toBe('boolean');
    expect(Field::Data->type())->toBe('object');
    expect(Field::ForeignId->type())->toBe('key');
    expect(Field::Uuid->type())->toBe('key');
    expect(Field::Token->type())->toBe('key');
    expect(Field::CreatedBy->type())->toBe('key');
    expect(Field::UpdatedBy->type())->toBe('key');
    expect(Field::Name->type())->toBe('string');
    expect(Field::Undefined->type())->toBe('string');
});

