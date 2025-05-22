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

            $gameInstance->programmingGame()->create([
                'Name' => $request->input('programming_game.name'),
                'Activated' => true,
                'ProgrammerId' => $gameInstance->ProfessorId,
                'StartTime' => $request->input('programming_game.start_time'),
                'EndTime' => $request->input('programming_game.end_time'),
                'Attempts' => $request->input('programming_game.attempts'),
                'MaximumTime' => $request->input('programming_game.maximum_time'),
                'GameInstancesId' => $gameInstance->Id
            ]);

            // Aquí se verifica qué tipo de juego se debe crear adicionalmente
            switch ($request->input('game_type')) {
                case 'hangman':
                    $gameInstance->hangman()->create([
                        'Word' => $request->input('hangman.word'),
                        'Clue' => $request->input('hangman.clue'),
                        'Presentation' => $request->input('hangman.presentation'),
                        'GameInstanceId' => $gameInstance->Id
                    ]);
                    break;

                case 'memory':
                    $gameInstance->memoryGame()->create([
                        'Mode' => $request->input('memory.mode'),
                        'PathImg1' => $request->input('memory.path_img1'),
                        'PathImg2' => $request->input('memory.path_img2'),
                        'DescriptionImg' => $request->input('memory.description_img'),
                        'GameInstanceId' => $gameInstance->Id
                    ]);
                    break;

                case 'puzzle':
                    $gameInstance->puzzle()->create([
                        'Pieces' => $request->input('puzzle.pieces'),
                        'ImageUrl' => $request->input('puzzle.image_url'),
                        'GameInstanceId' => $gameInstance->Id
                    ]);
                    break;

                case 'solve_the_word':
                    $solveTheWord = $gameInstance->solveTheWord()->create([
                        'Rows' => $request->input('solve_the_word.rows'),
                        'Columns' => $request->input('solve_the_word.columns'),
                        'GameInstanceId' => $gameInstance->Id
                    ]);
                    $words = $request->input('solve_the_word.words', []);
                    foreach ($words as $wordData) {
                        // Aquí asumo que tienes un modelo Word vinculado a SolveTheWord
                        $solveTheWord->words()->create([
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
}
