<?php
class Cave
{
    public function create(PDO $connection)
    {
        $this->includeFisrtAdmin($connection);
        $this->includeFirstPage($connection);
    }
    
    public function update(PDO $connection)
    {
    }
    
    private function includeFisrtAdmin(PDO $connection)
    {
        $stm = $connection->prepare(
            '
                INSERT admins
                SET
                    id=:id
                   ,name=:name
                   ,email=:email
                   ,password=:password
                   ,avatar=:avatar
            '
        );

        //
        // Standard avatar.
        //
        $avatar = '/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA8AAD/4QMdaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzEzOCA3OS4xNTk4MjQsIDIwMTYvMDkvMTQtMDE6MDk6MDEgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjREQUNCQTkxREZENzExRTdCOTAyREQ2RTBGNzQzQzQyIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjREQUNCQTkwREZENzExRTdCOTAyREQ2RTBGNzQzQzQyIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IFdpbmRvd3MiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0iREIzNzU4MUY1RjUxQ0UxNDIzREU0NDk0Q0U4Q0FEQ0UiIHN0UmVmOmRvY3VtZW50SUQ9IkRCMzc1ODFGNUY1MUNFMTQyM0RFNDQ5NENFOENBRENFIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+/+4ADkFkb2JlAGTAAAAAAf/bAIQABgQEBAUEBgUFBgkGBQYJCwgGBggLDAoKCwoKDBAMDAwM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';

        $stm->bindValue(':id', 1, PDO::PARAM_INT);
        $stm->bindValue(':name', 'Administrator', PDO::PARAM_STR);
        $stm->bindValue(':email', 'admin@host', PDO::PARAM_STR);
        $stm->bindValue(':password', 'admin', PDO::PARAM_STR);
        $stm->bindValue(':avatar', base64_decode($avatar), PDO::PARAM_STR);

        $stm->execute();
    }
    
    private function includeFirstPage(PDO $connection)
    {
        $stm = $connection->prepare(
            '
                INSERT pages
                SET
                    id=:id
                   ,token=:token
                   ,layout=:layout
                   ,title=:title
            '
        );

        $stm->bindValue(':id', 1, PDO::PARAM_INT);
        $stm->bindValue(':token', '/', PDO::PARAM_STR);
        $stm->bindValue(':layout', 'sample', PDO::PARAM_STR);
        $stm->bindValue(':title', 'Squille - Sample', PDO::PARAM_STR);

        $stm->execute();
    }
}

return new Cave();
