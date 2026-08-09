<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Models\BlogCategory;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('blog_category_id')
                ->label('Category')
                ->options(fn () => BlogCategory::pluck('name', 'id'))
                ->searchable()
                ->required(),
            TextInput::make('title')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(fn (string $state, callable $set) => $set('slug', Str::slug($state))),
            TextInput::make('slug')->required()->unique(ignoreRecord: true)->maxLength(255),
            Select::make('user_id')
                ->label('Author')
                ->relationship('author', 'name')
                ->default(fn () => Auth::id())
                ->searchable()
                ->required(),
            FileUpload::make('featured_image')->image()->directory('blog'),
            Textarea::make('excerpt')->maxLength(500)->columnSpanFull(),
            RichEditor::make('content')->required()->columnSpanFull(),
            Toggle::make('is_published')->live(),
            DateTimePicker::make('published_at')
                ->default(now())
                ->visible(fn (callable $get) => (bool) $get('is_published')),
        ]);
    }
}
