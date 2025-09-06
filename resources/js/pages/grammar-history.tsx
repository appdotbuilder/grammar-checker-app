import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Card, CardContent, CardHeader } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { ArrowLeft, Calendar, User, School } from 'lucide-react';

interface GrammarCheck {
    id: number;
    name: string;
    school: string;
    original_text: string;
    corrected_text: string;
    suggestions: string;
    score: number;
    created_at: string;
}

interface HistoryProps {
    grammarChecks: GrammarCheck[];
    [key: string]: unknown;
}

export default function GrammarHistory({ grammarChecks }: HistoryProps) {
    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    };

    const truncateText = (text: string, maxLength: number = 150) => {
        if (text.length <= maxLength) return text;
        return text.substring(0, maxLength) + '...';
    };

    return (
        <>
            <Head title="📚 History Grammar Check" />
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
                {/* Header */}
                <header className="border-b bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 dark:border-gray-700">
                    <div className="container mx-auto px-4 py-4">
                        <nav className="flex items-center justify-between">
                            <div className="flex items-center gap-4">
                                <Link href={route('home')}>
                                    <Button variant="outline" size="sm">
                                        <ArrowLeft className="w-4 h-4 mr-2" />
                                        Kembali
                                    </Button>
                                </Link>
                                <h1 className="text-xl font-bold text-gray-900 dark:text-white">
                                    📚 History Grammar Check
                                </h1>
                            </div>
                        </nav>
                    </div>
                </header>

                <main className="container mx-auto px-4 py-8 max-w-6xl">
                    <div className="text-center mb-8">
                        <h2 className="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            📋 Riwayat Pemeriksaan Grammar
                        </h2>
                        <p className="text-gray-600 dark:text-gray-300">
                            20 pemeriksaan terbaru yang telah dilakukan
                        </p>
                    </div>

                    {grammarChecks.length === 0 ? (
                        <Card className="text-center max-w-md mx-auto">
                            <CardContent className="pt-8 pb-8">
                                <div className="text-6xl mb-4">📝</div>
                                <h3 className="text-lg font-semibold mb-2">Belum Ada History</h3>
                                <p className="text-gray-600 dark:text-gray-400 mb-4">
                                    Anda belum melakukan pemeriksaan grammar apapun
                                </p>
                                <Link href={route('home')}>
                                    <Button>
                                        🚀 Mulai Sekarang
                                    </Button>
                                </Link>
                            </CardContent>
                        </Card>
                    ) : (
                        <div className="grid gap-6">
                            {grammarChecks.map((check) => (
                                <Card key={check.id} className="hover:shadow-lg transition-shadow">
                                    <CardHeader>
                                        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                            <div className="flex items-center gap-3">
                                                <Badge variant="secondary" className="text-xs">
                                                    #{check.id}
                                                </Badge>
                                                <Badge 
                                                    variant={check.score >= 90 ? "default" : check.score >= 80 ? "secondary" : "outline"}
                                                    className="text-xs"
                                                >
                                                    {check.score >= 90 ? '🏆' : check.score >= 80 ? '🌟' : check.score >= 70 ? '👍' : check.score >= 60 ? '👌' : '📚'} {check.score}/100
                                                </Badge>
                                                <div className="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                                    <User className="w-4 h-4" />
                                                    {check.name}
                                                </div>
                                                <div className="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                                    <School className="w-4 h-4" />
                                                    {check.school}
                                                </div>
                                            </div>
                                            <div className="flex items-center gap-2 text-sm text-gray-500">
                                                <Calendar className="w-4 h-4" />
                                                {formatDate(check.created_at)}
                                            </div>
                                        </div>
                                    </CardHeader>
                                    
                                    <CardContent className="space-y-4">
                                        {/* Original Text */}
                                        <div>
                                            <h4 className="text-sm font-semibold text-red-600 dark:text-red-400 mb-2">
                                                📝 Teks Asli:
                                            </h4>
                                            <p className="text-sm text-gray-700 dark:text-gray-300 bg-red-50 dark:bg-red-900/20 p-3 rounded-lg border border-red-200 dark:border-red-800">
                                                {truncateText(check.original_text)}
                                            </p>
                                        </div>

                                        {/* Corrected Text */}
                                        <div>
                                            <h4 className="text-sm font-semibold text-green-600 dark:text-green-400 mb-2">
                                                ✏️ Teks Diperbaiki:
                                            </h4>
                                            <p className="text-sm text-gray-700 dark:text-gray-300 bg-green-50 dark:bg-green-900/20 p-3 rounded-lg border border-green-200 dark:border-green-800">
                                                {truncateText(check.corrected_text)}
                                            </p>
                                        </div>

                                        {/* Suggestions */}
                                        <div>
                                            <h4 className="text-sm font-semibold text-blue-600 dark:text-blue-400 mb-2">
                                                💡 Catatan/Saran:
                                            </h4>
                                            <p className="text-sm text-gray-700 dark:text-gray-300 bg-blue-50 dark:bg-blue-900/20 p-3 rounded-lg border border-blue-200 dark:border-blue-800">
                                                {check.suggestions}
                                            </p>
                                        </div>
                                    </CardContent>
                                </Card>
                            ))}
                        </div>
                    )}

                    {/* Bottom Actions */}
                    <div className="text-center mt-8">
                        <Link href={route('home')}>
                            <Button className="bg-blue-600 hover:bg-blue-700">
                                🆕 Cek Grammar Baru
                            </Button>
                        </Link>
                    </div>
                </main>
            </div>
        </>
    );
}