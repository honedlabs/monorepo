<?php

// declare(strict_types=1);

// namespace Honed\Core\Enums;

// enum Field: string
// {
//     case Name = 'name';
//     case Email = 'email';
//     case Slug = 'slug';
//     case Password = 'password';
//     case Username = 'username';
//     case FirstName = 'first_name';
//     case LastName = 'last_name';
//     case Description = 'description';
//     case Status = 'status';
//     case Color = 'color';
//     case Code = 'code';
//     case Path = 'path';
//     case ForeignId = '*_id';
//     case StartsAt = 'starts_at';
//     case EndsAt = 'ends_at';
//     case IsBoolean = 'is_*';
//     case Details = 'details';
//     case Data = 'data';
//     case Phone = 'phone';
//     case Price = 'price';
//     case Quantity = 'quantity';
//     case Address = 'address';
//     case City = 'city';
//     case State = 'state';
//     case Zip = 'zip';
//     case Country = 'country';
//     case Duration = 'duration';
//     case Minutes = 'minutes';
//     case Uuid = 'uuid';
//     case Order = 'order';
//     case Token = 'token';
//     case Coordinate = 'coordinate';
//     case Latitude = 'latitude';
//     case Longitude = 'longitude';
//     case Version = 'version';
//     case Image = 'image';
//     case Url = 'url';
//     case CreatedBy = 'created_by';
//     case UpdatedBy = 'updated_by';
//     case IpAddress = 'ip_address';
//     case Icon = 'icon';

//     /** Coalseced for consistency */
//     case File = 'file';
//     case Title = 'title';
//     case Notes = 'notes';
//     case Priority = 'priority';
//     case Lat = 'lat';
//     case Long = 'long';
//     case Colour = 'colour';

//     /** Undefined */
//     case Undefined = 'undefined';

//     public function coalesced(): ?string
//     {
//         return match ($this) {
//             self::File => 'file',
//             self::Title => 'title',
//             self::Notes => 'details',
//             self::Priority => 'order',
//             self::Lat => 'latitude',
//             self::Long => 'longitude',
//             self::Colour => 'color',
//             default => null,
//         };
//     }

//     public function blueprint(mixed $name): string
//     {
//         return match ($this) {
//             self::Name, self::Title, => '$table->string(\'name\');',
//             self::Email => '$table->string(\'email\')->unique();',
//             self::Slug => '$table->string(\'slug\')->unique();',
//             self::Description => sprintf('$table->string(\'description\', %s)->nullable();', $this->length()),
//             self::Status => '$table->unsignedTinyInteger(\'status\')->default(0);',
//             self::Color, self::Colour => '$table->string(\'color\')->default(\'#000000\');',
//             self::Path, self::File => '$table->string(\'path\');',
//             self::ForeignId => sprintf('$table->foreignId(\'%s\')->constrained()->onDelete(\'cascade\');', $name),
//             self::StartsAt => '$table->dateTime(\'starts_at\');',
//             self::EndsAt => '$table->dateTime(\'ends_at\')->nullable();',
//             self::IsBoolean => sprintf('$table->boolean(\'%s\')->default(false);', $name),
//             self::Details, self::Notes => '$table->text(\'details\')->nullable();',
//             self::Data => '$table->json(\'data\')->nullable();',
//             self::Phone => '$table->string(\'phone\');',
//             self::Price => '$table->unsignedInteger(\'price\')',
//             self::Quantity => '$table->integer(\'quantity\')',
//             self::Country => '$table->string(\'country\');',
//             self::Duration => '$table->unsignedInteger(\'duration\');',
//             self::Minutes => '$table->unsignedInteger(\'minutes\');',
//             self::Uuid => '$table->uuid(\'uuid\');',
//             self::Order, self::Priority => '$table->unsignedSmallInteger(\'order\');',
//             self::Coordinate => '$table->point(\'coordinate\')',
//             self::Latitude, self::Lat => '$table->decimal(\'latitude\', 10, 8)',
//             self::Longitude, self::Long => '$table->decimal(\'longitude\', 11, 8)',
//             self::Version => '$table->unsignedSmallInteger(\'version\')',
//             self::CreatedBy => '$table->foreignId(\'created_by\')->nullable()->constrained(\'users\')->onDelete(\'cascade\');',
//             self::UpdatedBy => '$table->foreignId(\'updated_by\')->nullable()->constrained(\'users\')->onDelete(\'cascade\');',
//             default => sprintf('$table->string(\'%s\');', $name),
//         };
//     }

//     public function length(): int
//     {
//         return match ($this) {
//             self::Status,
//             self::Token,
//             self::Name, self::Title,
//             self::Email,
//             self::Slug,
//             self::Password,
//             self::Username,
//             self::FirstName,
//             self::LastName,
//             self::Color, self::Colour,
//             self::Code,
//             self::Path, self::File,
//             self::Phone,
//             self::Address,
//             self::City,
//             self::State,
//             self::Zip,
//             self::Country,
//             self::Image,
//             self::Icon, self::IpAddress => 255,
//             self::Url,
//             self::Description => 512,
//             self::Order, self::Priority,
//             self::Version,
//             self::Details,
//             self::Notes => 65535,

//             self::Data => 16777215,

//             self::Quantity => 2147483647,

//             self::Price,
//             self::Duration,
//             self::Minutes => 4294967295,
//             default => 0,
//         };
//     }

//     public function rules(string $name, ?string $table = null): string
//     {
//         return match ($this) {
//             self::Email => sprintf('[\'required\', \'email\', %s]', sprintf('max:%s', $this->length())),
//             self::Slug => sprintf('[\'required\', \'string\', \'lowercase\', %s, %s]', sprintf('unique:%s,slug', str($table)->plural()->value()), sprintf('max:%s', $this->length())),
//             self::Password => sprintf('[\'required\', \'string\', \'min:8\', %s]', sprintf('max:%s', $this->length())),
//             self::Description => sprintf('[\'nullable\', \'string\', %s]', sprintf('max:%s', $this->length())),
//             self::Status => sprintf('[\'required\', \'integer\', \'min:0\', %s]', sprintf('max:%s', $this->length())),
//             self::Color, self::Colour => sprintf('[\'nullable\', \'hex_color\', %s]', sprintf('max:%s', $this->length())),
//             self::ForeignId => sprintf('[\'required\', \'integer\', %s]', sprintf('exists:%s,id', str($name)->plural()->replaceLast('_id', ''))),
//             self::StartsAt => sprintf('[\'required\', \'date\', \'after_or_equal:now\']'),
//             self::EndsAt => sprintf('[\'nullable\', \'date\', \'after_or_equal:now\']'),
//             self::IsBoolean => sprintf('[\'required\', \'boolean\']'),
//             self::Details, self::Notes => sprintf('[\'nullable\', \'string\', %s]', sprintf('max:%s', $this->length())),
//             self::Data => sprintf('[\'required\', \'json\', %s]', sprintf('max:%s', $this->length())),
//             self::Price => sprintf('[\'required\', \'integer\', \'min:0\', %s]', sprintf('max:%s', $this->length())),
//             self::Quantity, self::Duration, self::Minutes => sprintf('[\'required\', \'integer\', \'min:0\', %s]', sprintf('max:%s', $this->length())),
//             self::Uuid => sprintf('[\'required\', \'uuid\']'),
//             self::Order, self::Priority => sprintf('[\'required\', \'integer\', \'min:0\', %s]', sprintf('max:%s', $this->length())),
//             self::Token => sprintf('[\'required\', \'alpha_num\', %s]', sprintf('max:%s', $this->length())),
//             self::Coordinate => sprintf('[\'required\', \'point\']'),
//             self::Latitude => sprintf('[\'required\', \'decimal\', \'min:-90\', \'max:90\']'),
//             self::Longitude => sprintf('[\'required\', \'decimal\', \'min:-180\', \'max:180\']'),
//             self::Version => sprintf('[\'required\', \'integer\', \'min:0\', %s]', sprintf('max:%s', $this->length())),
//             self::IpAddress => sprintf('[\'required\', \'ip\']'),
//             self::Undefined => sprintf('[\'required\']'),
//             self::Url => sprintf('[\'required\', \'url\', %s]', sprintf('max:%s', $this->length())),
//             default => sprintf('[\'required\', \'string\', %s]', sprintf('max:%s', $this->length())),
//         };
//     }

//     public function cast(): ?string
//     {
//         return match ($this) {
//             self::StartsAt, self::EndsAt => '\'datetime\'',
//             self::Data => '\'json\'',
//             default => null,
//         };
//     }

//     public function hidden(): bool
//     {
//         return match ($this) {
//             self::ForeignId,
//             self::CreatedBy,
//             self::UpdatedBy,
//             self::Password,
//             self::Token => true,
//             default => false,
//         };
//     }

//     public function factory(): string
//     {
//         return match ($this) {
//             self::Name, self::Title => 'fake()->name()',
//             self::Email => 'fake()->unique()->safeEmail()',
//             self::Slug => 'fake()->unique()->slug()',
//             self::Password => 'fake()->password(8)',
//             self::Username => 'fake()->unique()->userName()',
//             self::FirstName => 'fake()->firstName()',
//             self::LastName => 'fake()->lastName()',
//             self::Description => 'fake()->text(512)',
//             self::Status => 'fake()->numberBetween(0, 6)',
//             self::Color, self::Colour => 'fake()->hexColor()',
//             self::Code => 'fake()->unique()->regexify(\'[A-Z0-9]{5}\')',
//             self::Path, self::File => 'fake()->filePath()',
//             self::StartsAt => 'fake()->dateTimeBetween(\'-1 year\', \'now\')',
//             self::EndsAt => 'fake()->dateTimeBetween(\'now\', \'+1 year\')',
//             self::IsBoolean => 'fake()->boolean()',
//             self::Details, self::Notes => 'fake()->text(65535)',
//             self::Data => 'fake()->json()',
//             self::Phone => 'fake()->phoneNumber()',
//             self::Price => 'fake()->numberBetween(0, 10000)',
//             self::Quantity => 'fake()->numberBetween(0, 1000000)',
//             self::Address => 'fake()->address()',
//             self::City => 'fake()->city()',
//             self::State => 'fake()->state()',
//             self::Zip => 'fake()->postcode()',
//             self::Country => 'fake()->country()',
//             self::Duration => 'fake()->numberBetween(0, 300)',
//             self::Minutes => 'fake()->numberBetween(0, 300)',
//             self::Uuid => 'fake()->uuid()',
//             self::Order, self::Priority => 'fake()->numberBetween(0, 100)',
//             self::Token => 'fake()->regexify(\'[A-Z0-9]{32}\')',
//             self::Coordinate => 'fake()->point()',
//             self::Latitude, self::Lat => 'fake()->latitude()',
//             self::Longitude, self::Long => 'fake()->longitude()',
//             self::Version => 'fake()->numberBetween(0, 100)',
//             self::Image => 'fake()->imageUrl()',
//             self::Url => 'fake()->url()',
//             self::IpAddress => 'fake()->ipv4()',
//             self::Icon => 'fake()->slug()',
//             default => 'null', // Id's
//         };
//     }

//     public function hasRelationship(): bool
//     {
//         return match ($this) {
//             self::ForeignId,
//             self::CreatedBy,
//             self::UpdatedBy => true,
//             default => false,
//         };
//     }

//     public function isUndefined(): bool
//     {
//         return $this === self::Undefined;
//     }

//     public static function tryWithPatterns(string $name): Field
//     {
//         return match (true) {
//             str($name)->endsWith('_id') => self::ForeignId,
//             str($name)->startsWith('is_') => self::IsBoolean,
//             default => self::tryFrom($name) ?? self::Undefined,
//         };
//     }

//     public function internal(): bool
//     {
//         return match ($this) {
//             self::Uuid,
//             self::CreatedBy,
//             self::UpdatedBy => true,
//             default => false,
//         };
//     }

//     public function precedence(): int
//     {
//         return match ($this) {
//             self::ForeignId => 2,
//             self::Email,
//             self::Title,
//             self::Name,
//             self::Slug => 1,
//             self::CreatedBy,
//             self::UpdatedBy => -1,
//             default => 0,
//         };
//     }

//     public function relationship(string $field, ?string $table = null): ?string
//     {
//         if (! $this->hasRelationship()) {
//             return null;
//         }

//         /** user_id */
//         $name = str($field)->replace('_id', '')->replace('*', '')->lower()->value();

//         $signature = match (true) {
//             (bool) $table => str($table)->plural()->camel()->value(),
//             $name === Field::CreatedBy->value => 'creator',
//             $name === Field::UpdatedBy->value => 'updater',
//             default => str($name)->singular()->camel()->value()
//         };

//         $model = str(match (true) {
//             (bool) $table => $table,
//             $name === Field::CreatedBy->value => 'user',
//             $name === Field::UpdatedBy->value => 'user',
//             default => $name
//         })->singular()->studly()->value();

//         return sprintf(
//             'public function %s()
//             {
//                 return $this->%s(%s::class);
//             }
//             ', $signature, (bool) $table ? 'hasMany' : 'belongsTo', $model
//         );
//     }

//     /**
//      * @return array{string, Field}
//      */
//     public static function dataPair(string $name): array
//     {
//         return [
//             $name,
//             self::tryWithPatterns($name),
//         ];
//     }

//     public function type(): string
//     {
//         return match ($this) {
//             self::Price,
//             self::Quantity,
//             self::Duration,
//             self::Minutes,
//             self::Order,
//             self::Priority,
//             self::Version,
//             self::Latitude,
//             self::Longitude => 'numeric',
//             self::StartsAt,
//             self::EndsAt => 'date',
//             self::IsBoolean => 'boolean',
//             self::Data => 'object',
//             self::ForeignId,
//             self::Uuid,
//             self::Token,
//             self::CreatedBy,
//             self::UpdatedBy => 'key',
//             default => 'string',
//         };
//     }
// }
