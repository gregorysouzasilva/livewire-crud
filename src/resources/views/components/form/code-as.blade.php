<div class="code-block">
    <pre>
        <button class="copy-button" onclick="copyElemById('{{$id}}')" style="float: right">Copy</button>
        <code id="{{$id}}">
            tell application "Acrobat Pro"
                activate
            end tell
            tell application "System Events"
            delay 3
            {{ $slot }}
            end tell
        </code>
    </pre>
</div>