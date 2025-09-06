import React, { useState } from 'react';
import { type SharedData } from '@/types';
import { Head, Link, usePage, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { CheckCircle, BookOpen, Zap, Users } from 'lucide-react';

interface GrammarResult {
    original_text: string;
    corrected_text: string;
    suggestions: string;
    name: string;
    school: string;
}

interface WelcomeProps {
    result?: GrammarResult;
    [key: string]: unknown;
}

interface GrammarFormData {
    name: string;
    school: string;
    text: string;
    [key: string]: string;
}

export default function Welcome({ result }: WelcomeProps) {
    const { auth } = usePage<SharedData>().props;
    const [showResult, setShowResult] = useState(!!result);

    const { data, setData, post, processing, errors, reset } = useForm<GrammarFormData>({
        name: '',
        school: '',
        text: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('grammar-check.store'), {
            preserveState: false,
            onSuccess: () => {
                setShowResult(true);
            }
        });
    };

    const handleNewCheck = () => {
        setShowResult(false);
        reset();
    };

    return (
        <>
            <Head title="📝 Grammar Checker - Periksa Tata Bahasa Tulisan Anda">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
                {/* Header */}
                <header className="border-b bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 dark:border-gray-700">
                    <div className="container mx-auto px-4 py-4">
                        <nav className="flex items-center justify-between">
                            <div className="flex items-center gap-3">
                                <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <BookOpen className="w-5 h-5 text-white" />
                                </div>
                                <h1 className="text-xl font-bold text-gray-900 dark:text-white">
                                    📝 Grammar Checker
                                </h1>
                            </div>
                            <div className="flex items-center gap-4">
                                {auth.user ? (
                                    <>
                                        <Link
                                            href={route('grammar-check.history')}
                                            className="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white"
                                        >
                                            History
                                        </Link>
                                        <Link
                                            href={route('dashboard')}
                                            className="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors"
                                        >
                                            Dashboard
                                        </Link>
                                    </>
                                ) : (
                                    <>
                                        <Link
                                            href={route('login')}
                                            className="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white"
                                        >
                                            Masuk
                                        </Link>
                                        <Link
                                            href={route('register')}
                                            className="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors"
                                        >
                                            Daftar
                                        </Link>
                                    </>
                                )}
                            </div>
                        </nav>
                    </div>
                </header>

                <main className="container mx-auto px-4 py-8 max-w-6xl">
                    {!showResult ? (
                        <>
                            {/* Hero Section */}
                            <div className="text-center mb-12">
                                <h2 className="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                                    🚀 Periksa Tata Bahasa Tulisan Anda
                                </h2>
                                <p className="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
                                    Aplikasi canggih untuk memeriksa grammar, spelling, punctuation, dan struktur kalimat. 
                                    Dapatkan feedback yang clear & natural! ✨
                                </p>

                                {/* Features */}
                                <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                                    <Card className="border-blue-200 dark:border-blue-800">
                                        <CardContent className="pt-6">
                                            <div className="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 dark:bg-blue-900">
                                                <CheckCircle className="w-6 h-6 text-blue-600 dark:text-blue-400" />
                                            </div>
                                            <h3 className="font-semibold mb-2">Grammar Check</h3>
                                            <p className="text-sm text-gray-600 dark:text-gray-400">
                                                Deteksi dan perbaikan otomatis tata bahasa yang tepat
                                            </p>
                                        </CardContent>
                                    </Card>

                                    <Card className="border-green-200 dark:border-green-800">
                                        <CardContent className="pt-6">
                                            <div className="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 dark:bg-green-900">
                                                <Zap className="w-6 h-6 text-green-600 dark:text-green-400" />
                                            </div>
                                            <h3 className="font-semibold mb-2">Instant Results</h3>
                                            <p className="text-sm text-gray-600 dark:text-gray-400">
                                                Hasil pemeriksaan langsung dengan saran perbaikan
                                            </p>
                                        </CardContent>
                                    </Card>

                                    <Card className="border-purple-200 dark:border-purple-800">
                                        <CardContent className="pt-6">
                                            <div className="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4 dark:bg-purple-900">
                                                <Users className="w-6 h-6 text-purple-600 dark:text-purple-400" />
                                            </div>
                                            <h3 className="font-semibold mb-2">For Students</h3>
                                            <p className="text-sm text-gray-600 dark:text-gray-400">
                                                Khusus dirancang untuk kebutuhan akademis siswa
                                            </p>
                                        </CardContent>
                                    </Card>
                                </div>
                            </div>

                            {/* Grammar Check Form */}
                            <Card className="max-w-2xl mx-auto">
                                <CardHeader>
                                    <CardTitle className="text-2xl text-center">
                                        📄 Mulai Cek Grammar
                                    </CardTitle>
                                    <CardDescription className="text-center">
                                        Isi form di bawah untuk memulai pengecekan tata bahasa
                                    </CardDescription>
                                </CardHeader>
                                <CardContent>
                                    <form onSubmit={handleSubmit} className="space-y-6">
                                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div className="space-y-2">
                                                <Label htmlFor="name">Nama Lengkap *</Label>
                                                <Input
                                                    id="name"
                                                    type="text"
                                                    placeholder="Masukkan nama lengkap"
                                                    value={data.name}
                                                    onChange={(e) => setData('name', e.target.value)}
                                                    className={errors.name ? 'border-red-500' : ''}
                                                />
                                                {errors.name && (
                                                    <p className="text-sm text-red-600">{errors.name}</p>
                                                )}
                                            </div>

                                            <div className="space-y-2">
                                                <Label htmlFor="school">Asal Sekolah *</Label>
                                                <Input
                                                    id="school"
                                                    type="text"
                                                    placeholder="Masukkan asal sekolah"
                                                    value={data.school}
                                                    onChange={(e) => setData('school', e.target.value)}
                                                    className={errors.school ? 'border-red-500' : ''}
                                                />
                                                {errors.school && (
                                                    <p className="text-sm text-red-600">{errors.school}</p>
                                                )}
                                            </div>
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="text">Teks yang Akan Dicek *</Label>
                                            <Textarea
                                                id="text"
                                                placeholder="Masukkan teks yang ingin dicek grammar-nya... (minimal 10 karakter)"
                                                className={`min-h-[200px] ${errors.text ? 'border-red-500' : ''}`}
                                                value={data.text}
                                                onChange={(e) => setData('text', e.target.value)}
                                            />
                                            {errors.text && (
                                                <p className="text-sm text-red-600">{errors.text}</p>
                                            )}
                                            <p className="text-sm text-gray-500">
                                                {data.text.length}/10,000 karakter
                                            </p>
                                        </div>

                                        <Button 
                                            type="submit" 
                                            className="w-full bg-blue-600 hover:bg-blue-700"
                                            disabled={processing}
                                        >
                                            {processing ? (
                                                <>
                                                    <div className="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin mr-2"></div>
                                                    Sedang Memproses...
                                                </>
                                            ) : (
                                                <>🔍 Periksa Grammar</>
                                            )}
                                        </Button>
                                    </form>
                                </CardContent>
                            </Card>
                        </>
                    ) : result && (
                        /* Results Section */
                        <div className="max-w-4xl mx-auto space-y-6">
                            <div className="text-center mb-8">
                                <h2 className="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                    ✅ Hasil Pemeriksaan Grammar
                                </h2>
                                <p className="text-gray-600 dark:text-gray-300">
                                    Hasil untuk {result.name} dari {result.school}
                                </p>
                            </div>

                            {/* Original Text */}
                            <Card>
                                <CardHeader>
                                    <CardTitle className="text-lg text-red-600 dark:text-red-400">
                                        📝 Teks Asli:
                                    </CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <p className="text-gray-700 dark:text-gray-300 leading-relaxed bg-red-50 dark:bg-red-900/20 p-4 rounded-lg border border-red-200 dark:border-red-800">
                                        {result.original_text}
                                    </p>
                                </CardContent>
                            </Card>

                            {/* Corrected Text */}
                            <Card>
                                <CardHeader>
                                    <CardTitle className="text-lg text-green-600 dark:text-green-400">
                                        ✏️ Teks Diperbaiki:
                                    </CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <p className="text-gray-700 dark:text-gray-300 leading-relaxed bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-800">
                                        {result.corrected_text}
                                    </p>
                                </CardContent>
                            </Card>

                            {/* Suggestions */}
                            <Card>
                                <CardHeader>
                                    <CardTitle className="text-lg text-blue-600 dark:text-blue-400">
                                        💡 Catatan/Saran:
                                    </CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <p className="text-gray-700 dark:text-gray-300 leading-relaxed bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                                        {result.suggestions}
                                    </p>
                                </CardContent>
                            </Card>

                            {/* Action Buttons */}
                            <div className="flex flex-col sm:flex-row gap-4 justify-center pt-6">
                                <Button 
                                    onClick={handleNewCheck}
                                    className="bg-blue-600 hover:bg-blue-700"
                                >
                                    🆕 Cek Teks Baru
                                </Button>
                                {auth.user && (
                                    <Link href={route('grammar-check.history')}>
                                        <Button variant="outline">
                                            📚 Lihat History
                                        </Button>
                                    </Link>
                                )}
                            </div>
                        </div>
                    )}
                </main>

                {/* Footer */}
                <footer className="mt-16 border-t bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 dark:border-gray-700">
                    <div className="container mx-auto px-4 py-6">
                        <div className="text-center text-gray-600 dark:text-gray-400">
                            <p className="mb-2">
                                📝 <strong>Grammar Checker</strong> - Aplikasi untuk memeriksa tata bahasa tulisan
                            </p>
                            <p className="text-sm">
                                Dibuat dengan ❤️ menggunakan Laravel & React
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}