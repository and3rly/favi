import { useStore1, useStore2, useStore3 } from '@/stores'

export default {
  setup() {
    const store1 = useStore1()
    const store2 = useStore2()
    const store3 = useStore3()

    return { store1, store2, store3 }
  },
}