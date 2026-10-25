<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background-color: #f3f4f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 100%;
            max-width: 500px;
            padding: 32px;
        }

        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        p.subtitle {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 24px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.875rem;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #def7ec;
            color: #03543f;
            border: 1px solid #bcf0da;
        }

        .alert-error {
            background-color: #fde8e8;
            color: #9b1c1c;
            border: 1px solid #f8b4b4;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            font-size: 0.875rem;
            color: #374151;
            margin-bottom: 8px;
        }

        .file-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background-color: #f9fafb;
            font-size: 0.875rem;
            cursor: pointer;
        }

        .file-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .btn-submit {
            width: 100%;
            background-color: #2563eb;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.15s ease-in-out;
        }

        .btn-submit:hover {
            background-color: #1d4ed8;
        }

        .file-link {
            display: inline-block;
            margin-top: 8px;
            color: #1d4ed8;
            font-weight: 500;
            word-break: break-all;
        }
    </style>
</head>
<body>

    <div class="card">
        <h1>Upload File</h1>
        <p class="subtitle">Select a file from your computer to upload to the server.</p>

        {{-- Success Notification --}}
        @if (session('success'))
            <div class="alert alert-success">
                <strong>{{ session('success') }}</strong><br>
                <span>File: {{ session('fileName') }}</span><br>
                <a href="{{ session('fileUrl') }}" target="_blank" class="file-link">View Uploaded File &rarr;</a>
            </div>
        @endif

        {{-- Error Notification --}}
        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- HTML Form: Note the enctype="multipart/form-data" --}}
        <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="file">Choose File</label>
                <input type="file" name="file" id="file" class="file-input" required>
            </div>

            <button type="submit" class="btn-submit">Upload File</button>
        </form>
    </div>

</body>
</html>

