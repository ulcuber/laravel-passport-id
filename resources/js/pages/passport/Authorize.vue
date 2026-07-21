<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Alert, AlertTitle, AlertDescription } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';

defineOptions({
    layout: {
        title: 'Authorization',
        description: 'Authorization Request',
    },
});

interface Client {
    id: string;
    name: string;
}

interface Scope {
    description: string;
}

interface Request {
    state: string;
}

defineProps<{
    client: Client;
    scopes: Scope[];
    request: Request;
    authToken: string;
}>();
</script>

<template>
    <Head title="Authorization" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <Alert>
            <AlertTitle>
                <strong>{{ client.name }}</strong> is requesting permission to
                access your account.
            </AlertTitle>
            <AlertDescription>
                <p><strong>This application will be able to:</strong></p>
                <ul>
                    <li v-for="scope in scopes" :key="scope.description">
                        {{ scope.description }}
                    </li>
                </ul>
            </AlertDescription>
        </Alert>

        <div class="buttons">
            <!-- Authorize Button route('passport.authorizations.approve') -->
            <form method="post" action="/oauth/authorize">
                <input type="hidden" name="state" :value="request.state" />
                <input type="hidden" name="client_id" :value="client.id" />
                <input type="hidden" name="auth_token" :value="authToken" />
                <Button type="submit" class="mt-4 w-full" :tabindex="4">
                    Authorize
                </Button>
            </form>

            <Separator />

            <!-- Cancel Button route('passport.authorizations.deny') -->
            <form method="post" action="/oauth/authorize">
                <input type="hidden" name="_method" value="DELETE" />
                <input type="hidden" name="state" :value="request.state" />
                <input type="hidden" name="client_id" :value="client.id" />
                <input type="hidden" name="auth_token" :value="authToken" />
                <Button
                    type="submit"
                    class="mt-4 w-full"
                    :tabindex="4"
                    variant="destructive"
                >
                    Cancel
                </Button>
            </form>
        </div>
    </div>
</template>
