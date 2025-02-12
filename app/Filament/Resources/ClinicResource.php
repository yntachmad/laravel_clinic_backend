<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Clinic;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ClinicResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClinicResource\RelationManagers;

class ClinicResource extends Resource
{
    protected static ?string $model = Clinic::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                //
                FileUpload::make('image')->label('Logo')
                    ->directory('logo')->image()
                    ->avatar()
                    ->imageEditor()
                    ->circleCropper(),

                TextInput::make('name')->helperText(new HtmlString('Your <strong>full name</strong> here, including any middle names.'))->string(),
                TextInput::make('address')->required(),
                TextInput::make('phone')->hint('Forgotten your password? Bad luck.'),
                TextInput::make('email')->email()->hint(new HtmlString('<a href="/forgotten-password">Forgotten your password?</a>'))->unique(table: User::class),
                TimePicker::make('open_time'),
                TimePicker::make('close_time')->seconds(false),

                TextInput::make('website'),
                TextInput::make('specialist'),
                Textarea::make('note')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('address'),
                TextColumn::make('phone'),
                TextColumn::make('email'),
                ImageColumn::make('image')


            ])
            ->filters([
                //
                Filter::make('name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClinics::route('/'),
            'create' => Pages\CreateClinic::route('/create'),
            'edit' => Pages\EditClinic::route('/{record}/edit'),
        ];
    }
}
