<div class="cr-course cr-create-course">
    <div class="container">
        <livewire:courses::course-sidebar :tab="$tab" :id="$id" :tabs="$tabs" />
        <livewire:dynamic-component :component="'courses::course-'.$tab" :tab="$tab" :id="$id" />
    </div>
</div>
