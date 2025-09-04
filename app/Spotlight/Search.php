<?php

namespace App\Spotlight;

use App\Models\User;
use App\Services\SiteService;
use Illuminate\Http\Request;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;

class Search extends SpotlightCommand
{
    /**
     * This is the name of the command that will be shown in the Spotlight component.
     */
    protected string $name = 'Search by tutor name or subject';

    /**
     * This is the description of your command which will be shown besides the command name.
     */
    protected string $description = 'This will redirect to find-tutors page';

    /**
     * You can define any number of additional search terms (also known as synonyms)
     * to be used when searching for this command.
     */
    protected array $synonyms = ['find','search','tutors','subjects'];

    /**
     * Defining dependencies is optional. If you don't have any dependencies you can remove this method.
     * Dependencies are asked from your user in the order you add the dependencies.
     */
    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('tutor')
                ->setPlaceholder('Enter Keyword to Search tutor by name or subject he teaches')
            );
    }

    /**
     * Spotlight will resolve dependencies by calling the search method followed by your dependency name.
     * The method will receive the search query as the parameter.
     */
    public function searchTutor($query)
    {
        return (new SiteService())->getTutors(['keyword'=>$query])->map(function(User $tutor) {
            return new SpotlightSearchResult(
                $tutor->id,
                $tutor->profile->full_name,
                sprintf('View Detail profile of Tutor %s', $tutor->profile->full_name)
            );
        });
    }

    /**
     * When all dependencies have been resolved the execute method is called.
     * You can type-hint all resolved dependency you defined earlier.
     */
    public function execute(Spotlight $spotlight, User $tutor)
    {
        $spotlight->redirectRoute('tutor-detail', ['slug' => $tutor->profile->slug]);
    }

    /**
     * You can provide any custom logic you want to determine whether the
     * command will be shown in the Spotlight component. If you don't have any
     * logic you can remove this method. You can type-hint any dependencies you
     * need and they will be resolved from the container.
     */
    public function shouldBeShown(Request $request): bool
    {
        return $request->user()->role == 'student';
    }
}
