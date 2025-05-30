<?php

namespace App\Domain\Services;

use App\Application\Traits\ApiResponse;
use App\Domain\Entities\GameInstances;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameService
{
    use ApiResponse;
    public function createGame(Request $request)
    {
        DB::beginTransaction();
        try {
            $gameInstance = GameInstances::create([
                'Name' => $request->input('Name'),
                'Description' => $request->input('Description'),
                'ProfessorId' => $request->input('ProfessorId'),
                'Activated' => $request->input('Activated'),
                'Difficulty' => $request->input('Difficulty'),
                'Visibility' => $request->input('Visibility')
            ]);

            foreach ($request->input('settings', []) as $setting) {
                $gameInstance->gameSetting()->create(
                    collect($setting)->only(['ConfigKey', 'ConfigValue'])->toArray()
                );

            }

            $gameInstance->assessments()->create([
                'UserId' => $gameInstance->ProfessorId,
                'Activated' => true,
                'Value' => $request->input('assessment.value'),
                'Comments' => $request->input('assessment.comments'),
                'GameInstanceId' => $gameInstance->Id
            ]);

            // Aquí se verifica qué tipo de juego se debe crear adicionalmente
            switch ($request->input('game_type')) {
                case 'hangman':
                    foreach ($request->input('hangman.words', []) as $wordData) {
                        $gameInstance->hangman()->create([
                            'Word' => $wordData['word'],
                            'Clue' => $wordData['clue'],
                            'Presentation' => $request->input('hangman.presentation'),
                            'GameInstanceId' => $gameInstance->Id
                        ]);
                    }
                    break;


                case 'memory':
                    $mode = $request->input('memory.mode');
                    $memoryItems = $request->input('memory.items', []);

                    foreach ($memoryItems as $item) {
                        $gameInstance->memoryGame()->create([
                            'Mode' => $mode,
                            'PathImg1' => $item['path_img1'],
                            'PathImg2' => $mode === 'II' ? $item['path_img2'] : null,
                            'DescriptionImg' => $mode === 'ID' ? $item['description_img'] : null,
                            'GameInstanceId' => $gameInstance->Id
                        ]);
                    }
                    break;

                case 'puzzle':
                    $gameInstance->puzzle()->create([
                        'GameInstanceId' => $gameInstance->Id,
                        'PathImg' => $request->input('puzzle.image_url'),
                        'Clue' => $request->input('puzzle.clue'),
                        'Rows' => $request->input('puzzle.rows'),
                        'Cols' => $request->input('puzzle.columns'),
                        'AutomaticHelp' => $request->input('puzzle.automatic_help', false),
                    ]);
                    break;


                case 'solve_the_word':
                    $solveTheWord = $gameInstance->solveTheWord()->create([
                        'Rows' => $request->input('solve_the_word.rows'),
                        'Cols' => $request->input('solve_the_word.columns'),
                        'GameInstanceId' => $gameInstance->Id
                    ]);

                    $words = $request->input('solve_the_word.words', []);
                    foreach ($words as $wordData) {
                        $solveTheWord->words()->create([
                            'SolveTheWordId' => $solveTheWord->GameInstanceId,
                            'Word' => $wordData['word'],
                            'Orientation' => $wordData['orientation'],
                        ]);
                    }
                    break;

            }

            DB::commit();

            return $this->successResponse($gameInstance, 2214);

        } catch (\Throwable $e) {
            DB::rollBack();
            logger()->error('Error al crear juego: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return $this->errorResponse(2215);
        }
    }

    public function getGameById(int $id): ?array
    {
        $game = GameInstances::with([
            'professor',
            'assessments',
            'hangman',
            'memoryGame',
            'puzzle',
            'solveTheWord.words', // Incluye palabras si es 'solve the word'
            'gameSetting'
        ])->find($id);

        if (!$game) {
            return null;
        }

        $type = 'Unknown';

        if ($game->hangman()->exists()) {
            $type = 'Hangman';
        } elseif ($game->memoryGame()->exists()) {
            $type = 'Memory';
        } elseif ($game->puzzle()->exists()) {
            $type = 'Puzzle';
        } elseif ($game->solveTheWord()->exists()) {
            $type = 'Solve the Word';
        }

        return [
            'id' => $game->Id,
            'title' => $game->Name,
            'description' => $game->Description,
            'difficulty' => $game->Difficulty,
            'visibility' => $game->Visibility,
            'activated' => $game->Activated,
            'rating' => $game->assessments->avg('Value') ?? 0,
            'assessment' => $game->assessments->map(fn($a) => [
                'value' => $a->Value,
                'comments' => $a->Comments,
            ]),
            'author' => $game->professor
                ? $game->professor->Name . ' ' . $game->professor->LastName
                : 'Unknown',
            'type' => $type,
            'settings' => $game->gameSetting->map(fn($s) => [
                'key' => $s->ConfigKey,
                'value' => $s->ConfigValue,
            ]),
            'game_data' => match ($type) {
                'Hangman' => [
                    'word' => $game->hangman->Word,
                    'clue' => $game->hangman->Clue,
                    'presentation' => $game->hangman->Presentation,
                ],
                'Memory' => [
                    'mode' => $game->memoryGame->Mode,
                    'path_img1' => $game->memoryGame->PathImg1,
                    'path_img2' => $game->memoryGame->PathImg2,
                    'description_img' => $game->memoryGame->DescriptionImg,
                ],
                'Puzzle' => [
                    'pieces' => $game->puzzle->Pieces,
                    'image_url' => $game->puzzle->ImageUrl,
                ],
                'Solve the Word' => [
                    'rows' => $game->solveTheWord->Rows,
                    'columns' => $game->solveTheWord->Columns,
                    'words' => $game->solveTheWord->words->map(fn($w) => [
                        'word' => $w->Word,
                        'orientation' => $w->Orientation,
                    ]),
                ],
                default => null,
            }
        ];
    }

}
