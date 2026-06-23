import { ref, watch } from 'vue';

const bus = ref(new Map());

export default function useEventsBus() {

    const emit = (event, props) => {
        const currentValue = bus.value.get(event);
        const counter = currentValue ? ++currentValue[1] : 1;
        bus.value.set(event, [props, counter]);
    };

    const on = (event, callback) => {
        watch(() => bus.value.get(event), (val) => {
            callback(val[0]);
        });
    };

    return {
        emit,
        on,
        bus,
    };
}