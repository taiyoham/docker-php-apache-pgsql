CREATE TABLE children (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    kana_name VARCHAR(100) NOT NULL,
    date_of_birth DATE NOT NULL,
    gender VARCHAR(10) NOT NULL,
    class_name VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    parent_name VARCHAR(100) NOT NULL,
    parent_contact VARCHAR(20) NOT NULL,
    emergency_contact VARCHAR(20),
    allergies TEXT,
    medical_notes TEXT,
    enrollment_date DATE NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- インデックスの作成
CREATE INDEX idx_children_name ON children(name);
CREATE INDEX idx_children_class_name ON children(class_name);
CREATE INDEX idx_children_status ON children(status);

-- トリガーの作成（updated_at列を自動更新する）
CREATE OR REPLACE FUNCTION update_modified_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;






-- デモ用の園児情報を挿入
INSERT INTO children (
    name, kana_name, date_of_birth, gender, class_name, address,
    parent_name, parent_contact, emergency_contact, allergies, medical_notes,
    enrollment_date, status
) VALUES
    ('山田太郎', 'ヤマダタロウ', '2019-05-10', '男', 'ひまわり', '東京都新宿区新宿1-1-1',
     '山田花子', '090-1234-5678', '03-1234-5678', 'なし', 'なし',
     '2022-04-01', 'Active'),
    ('佐藤美香', 'サトウミカ', '2020-02-15', '女', 'たんぽぽ', '東京都渋谷区渋谷2-2-2',
     '佐藤健一', '090-2345-6789', '03-2345-6789', '卵', '喘息持ち',
     '2023-04-01', 'Active'),
    ('鈴木一郎', 'スズキイチロウ', '2018-11-20', '男', 'さくら', '東京都品川区品川3-3-3',
     '鈴木真理', '090-3456-7890', '03-3456-7890', 'ピーナッツ', 'なし',
     '2021-04-01', 'Active'),
    ('田中花子', 'タナカハナコ', '2019-08-05', '女', 'ひまわり', '東京都目黒区目黒4-4-4',
     '田中誠', '090-4567-8901', '03-4567-8901', 'なし', 'てんかん持ち',
     '2022-04-01', 'Active'),
    ('伊藤雄太', 'イトウユウタ', '2020-06-30', '男', 'たんぽぽ', '東京都港区港5-5-5',
     '伊藤春香', '090-5678-9012', '03-5678-9012', '乳製品', 'なし',
     '2023-04-01', 'Active'),
    ('中村さくら', 'ナカムラサクラ', '2018-09-12', '女', 'さくら', '東京都中央区中央6-6-6',
     '中村洋平', '090-6789-0123', '03-6789-0123', 'なし', 'アトピー性皮膚炎',
     '2021-04-01', 'Active'),
    ('小林龍太', 'コバヤシリュウタ', '2019-12-25', '男', 'ひまわり', '東京都千代田区千代田7-7-7',
     '小林美咲', '090-7890-1234', '03-7890-1234', 'そば', 'なし',
     '2022-04-01', 'Active'),
    ('加藤梅子', 'カトウウメコ', '2020-04-01', '女', 'たんぽぽ', '東京都文京区文京8-8-8',
     '加藤勇気', '090-8901-2345', '03-8901-2345', 'なし', 'なし',
     '2023-04-01', 'Active'),
    ('吉田健太', 'ヨシダケンタ', '2018-07-07', '男', 'さくら', '東京都台東区台東9-9-9',
     '吉田恵子', '090-9012-3456', '03-9012-3456', 'エビ', '近視',
     '2021-04-01', 'Active'),
    ('渡辺美月', 'ワタナベミヅキ', '2019-10-31', '女', 'ひまわり', '東京都墨田区墨田10-10-10',
     '渡辺隆', '090-0123-4567', '03-0123-4567', 'なし', 'なし',
     '2022-04-01', 'Active');