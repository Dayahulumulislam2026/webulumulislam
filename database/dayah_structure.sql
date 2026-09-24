-- ==========================================================
-- SQL DUMP: SUSUNAN PENGURUS DAYAH ULUMUL ISLAM
-- Otomatis Mengisi Posisi & Anggota Pengurus Dayah
-- ==========================================================

SET @dayah_id = (SELECT id FROM institutions WHERE type = 'dayah' LIMIT 1);

-- 1. Bersihkan struktur lama dayah jika ada
DELETE FROM structure_members WHERE position_id IN (SELECT id FROM structure_positions WHERE institution_id = @dayah_id);
DELETE FROM structure_positions WHERE institution_id = @dayah_id;

-- 2. PIMPINAN UTAMA (Leader)
INSERT INTO structure_positions (institution_id, category, position_name, sort_order, is_pinned, is_active, created_at, updated_at)
VALUES (@dayah_id, 'leader', 'Pimpinan Dayah', 1, 1, 1, NOW(), NOW());
SET @pos_pimpinan = LAST_INSERT_ID();

INSERT INTO structure_members (position_id, name, member_role, title, period, sort_order, is_active, created_at, updated_at)
VALUES (@pos_pimpinan, 'TGK. H. BAIHAQI YAHYA, S.HI', 'leader', 'Pimpinan Dayah', '2024 - 2029', 1, 1, NOW(), NOW());

-- 3. WAKIL PIMPINAN (Vice)
INSERT INTO structure_positions (institution_id, category, position_name, sort_order, is_pinned, is_active, created_at, updated_at)
VALUES (@dayah_id, 'vice', 'Wakil Pimpinan Dayah', 2, 1, 1, NOW(), NOW());
SET @pos_wakil = LAST_INSERT_ID();

INSERT INTO structure_members (position_id, name, member_role, title, period, sort_order, is_active, created_at, updated_at)
VALUES (@pos_wakil, 'TGK. H. IBNU HAJAR YAHYA, S.AG', 'vice', 'Wakil Pimpinan Dayah', '2024 - 2029', 1, 1, NOW(), NOW());

-- 4. PAMONG (Vice / BPH)
INSERT INTO structure_positions (institution_id, category, position_name, sort_order, is_pinned, is_active, created_at, updated_at)
VALUES (@dayah_id, 'vice', 'Pamong', 3, 0, 1, NOW(), NOW());
SET @pos_pamong = LAST_INSERT_ID();

INSERT INTO structure_members (position_id, name, member_role, title, period, sort_order, is_active, created_at, updated_at) VALUES
(@pos_pamong, 'TGK. KAUSAR, M.PD', 'head', 'Ketua Pamong', '2024 - 2029', 1, 1, NOW(), NOW()),
(@pos_pamong, 'TGK. H. TARMIZI, S.AG', 'vice', 'Wakil Pamong', '2024 - 2029', 2, 1, NOW(), NOW());

-- 5. BENDAHARA (Vice / BPH)
INSERT INTO structure_positions (institution_id, category, position_name, sort_order, is_pinned, is_active, created_at, updated_at)
VALUES (@dayah_id, 'vice', 'Bendahara', 4, 0, 1, NOW(), NOW());
SET @pos_bendahara = LAST_INSERT_ID();

INSERT INTO structure_members (position_id, name, member_role, title, period, sort_order, is_active, created_at, updated_at) VALUES
(@pos_bendahara, 'TGK. H. TARMIZI, S.AG', 'head', 'Ketua Bendahara', '2024 - 2029', 1, 1, NOW(), NOW()),
(@pos_bendahara, 'TGK. KAUSAR, M.PD', 'member', 'Anggota I', '2024 - 2029', 2, 1, NOW(), NOW()),
(@pos_bendahara, 'TGK. ABDULLAH, S.P', 'member', 'Anggota II', '2024 - 2029', 3, 1, NOW(), NOW());

-- 6. SEKRETARIS (Vice / BPH)
INSERT INTO structure_positions (institution_id, category, position_name, sort_order, is_pinned, is_active, created_at, updated_at)
VALUES (@dayah_id, 'vice', 'Sekretaris', 5, 0, 1, NOW(), NOW());
SET @pos_sekretaris = LAST_INSERT_ID();

INSERT INTO structure_members (position_id, name, member_role, title, period, sort_order, is_active, created_at, updated_at) VALUES
(@pos_sekretaris, 'TGK. HASBIANI, S.HI', 'head', 'Ketua Sekretaris', '2024 - 2029', 1, 1, NOW(), NOW()),
(@pos_sekretaris, 'TGK. YUSRIZAL, S.E', 'member', 'Anggota I', '2024 - 2029', 2, 1, NOW(), NOW()),
(@pos_sekretaris, 'TGK. WAHYUNI, S.PdI', 'member', 'Anggota II', '2024 - 2029', 3, 1, NOW(), NOW());

-- 7. BAGIAN EKSTRAKURIKULER (Division)
INSERT INTO structure_positions (institution_id, category, position_name, sort_order, is_pinned, is_active, created_at, updated_at)
VALUES (@dayah_id, 'division', 'Bagian Ekstrakurikuler', 6, 0, 1, NOW(), NOW());
SET @pos_ekskul = LAST_INSERT_ID();

INSERT INTO structure_members (position_id, name, member_role, title, period, sort_order, is_active, created_at, updated_at) VALUES
(@pos_ekskul, 'TGK. ABDULLAH, S.PdI', 'head', 'Ketua', '2024 - 2029', 1, 1, NOW(), NOW()),
(@pos_ekskul, 'TGK. WAHYUNI, S.PdI', 'member', 'Anggota I', '2024 - 2029', 2, 1, NOW(), NOW()),
(@pos_ekskul, 'Ustzh. MUTIA FADHILLAH', 'member', 'Anggota II', '2024 - 2029', 3, 1, NOW(), NOW());

-- 8. BAGIAN KESEHATAN (Division)
INSERT INTO structure_positions (institution_id, category, position_name, sort_order, is_pinned, is_active, created_at, updated_at)
VALUES (@dayah_id, 'division', 'Bagian Kesehatan', 7, 0, 1, NOW(), NOW());
SET @pos_kesehatan = LAST_INSERT_ID();

INSERT INTO structure_members (position_id, name, member_role, title, period, sort_order, is_active, created_at, updated_at) VALUES
(@pos_kesehatan, 'TGK. YUSRIZAL, S.E', 'head', 'Ketua', '2024 - 2029', 1, 1, NOW(), NOW()),
(@pos_kesehatan, 'TGK. MUHARDI, S.Ag', 'member', 'Anggota I', '2024 - 2029', 2, 1, NOW(), NOW()),
(@pos_kesehatan, 'TGK. M. LUTFI, S.FU', 'member', 'Anggota II', '2024 - 2029', 3, 1, NOW(), NOW()),
(@pos_kesehatan, 'Ustzh. MUSYIRA', 'member', 'Anggota III', '2024 - 2029', 4, 1, NOW(), NOW());

-- 9. BAGIAN ASRAMA (Division)
INSERT INTO structure_positions (institution_id, category, position_name, sort_order, is_pinned, is_active, created_at, updated_at)
VALUES (@dayah_id, 'division', 'Bagian Asrama', 8, 0, 1, NOW(), NOW());
SET @pos_asrama = LAST_INSERT_ID();

INSERT INTO structure_members (position_id, name, member_role, title, period, sort_order, is_active, created_at, updated_at) VALUES
(@pos_asrama, 'TGK. KHAIRIZAL, S.FU', 'head', 'Ketua', '2024 - 2029', 1, 1, NOW(), NOW()),
(@pos_asrama, 'TGK. WAHYUNI, S.PdI', 'vice', 'Wakil Ketua', '2024 - 2029', 2, 1, NOW(), NOW());

-- 10. BAGIAN UQUBAH (Division)
INSERT INTO structure_positions (institution_id, category, position_name, sort_order, is_pinned, is_active, created_at, updated_at)
VALUES (@dayah_id, 'division', 'Bagian Uqubah', 9, 0, 1, NOW(), NOW());
SET @pos_uqubah = LAST_INSERT_ID();

INSERT INTO structure_members (position_id, name, member_role, title, period, sort_order, is_active, created_at, updated_at) VALUES
(@pos_uqubah, 'TGK. ASBAHANI', 'head', 'Ketua', '2024 - 2029', 1, 1, NOW(), NOW()),
(@pos_uqubah, 'TGK. MAULANA, S.FU', 'vice', 'Wakil Ketua', '2024 - 2029', 2, 1, NOW(), NOW());

-- 11. BAGIAN MAHKAMAH (Division)
INSERT INTO structure_positions (institution_id, category, position_name, sort_order, is_pinned, is_active, created_at, updated_at)
VALUES (@dayah_id, 'division', 'Bagian Mahkamah', 10, 0, 1, NOW(), NOW());
SET @pos_mahkamah = LAST_INSERT_ID();

INSERT INTO structure_members (position_id, name, member_role, title, period, sort_order, is_active, created_at, updated_at) VALUES
(@pos_mahkamah, 'TGK. WAHYUNI, S.PdI', 'head', 'Ketua', '2024 - 2029', 1, 1, NOW(), NOW()),
(@pos_mahkamah, 'TGK. YUSRIZAL, S.E', 'member', 'Anggota I', '2024 - 2029', 2, 1, NOW(), NOW()),
(@pos_mahkamah, 'TGK. ABDULLAH, S.PdI', 'member', 'Anggota II', '2024 - 2029', 3, 1, NOW(), NOW());

-- 12. BAGIAN PENDIDIKAN (Division)
INSERT INTO structure_positions (institution_id, category, position_name, sort_order, is_pinned, is_active, created_at, updated_at)
VALUES (@dayah_id, 'division', 'Bagian Pendidikan', 11, 0, 1, NOW(), NOW());
SET @pos_pendidikan = LAST_INSERT_ID();

INSERT INTO structure_members (position_id, name, member_role, title, period, sort_order, is_active, created_at, updated_at) VALUES
(@pos_pendidikan, 'TGK. MUHARDI, S.Ag', 'head', 'Ketua', '2024 - 2029', 1, 1, NOW(), NOW()),
(@pos_pendidikan, 'TGK. MUTTAQIN, S.PdI', 'member', 'Anggota I', '2024 - 2029', 2, 1, NOW(), NOW()),
(@pos_pendidikan, 'TGK. KHAIRIZAL, S.FU', 'member', 'Anggota II', '2024 - 2029', 3, 1, NOW(), NOW());

-- 13. BAGIAN KEAMANAN (Division)
INSERT INTO structure_positions (institution_id, category, position_name, sort_order, is_pinned, is_active, created_at, updated_at)
VALUES (@dayah_id, 'division', 'Bagian Keamanan', 12, 0, 1, NOW(), NOW());
SET @pos_keamanan = LAST_INSERT_ID();

INSERT INTO structure_members (position_id, name, member_role, title, period, sort_order, is_active, created_at, updated_at) VALUES
(@pos_keamanan, 'TGK. MUSLEM, S.Ud', 'head', 'Ketua', '2024 - 2029', 1, 1, NOW(), NOW()),
(@pos_keamanan, 'TGK. MUTTAQIN, S.PdI', 'member', 'Anggota I', '2024 - 2029', 2, 1, NOW(), NOW()),
(@pos_keamanan, 'TGK. KAUSAR, M.Pd', 'member', 'Anggota II', '2024 - 2029', 3, 1, NOW(), NOW()),
(@pos_keamanan, 'TGK. YUSRIZAL, S.E', 'member', 'Anggota III', '2024 - 2029', 4, 1, NOW(), NOW());

-- 14. BAGIAN LISTRIK & AIR (Division)
INSERT INTO structure_positions (institution_id, category, position_name, sort_order, is_pinned, is_active, created_at, updated_at)
VALUES (@dayah_id, 'division', 'Bagian Listrik & Air', 13, 0, 1, NOW(), NOW());
SET @pos_listrik = LAST_INSERT_ID();

INSERT INTO structure_members (position_id, name, member_role, title, period, sort_order, is_active, created_at, updated_at) VALUES
(@pos_listrik, 'TGK. ASBAHANI', 'head', 'Ketua', '2024 - 2029', 1, 1, NOW(), NOW()),
(@pos_listrik, 'TGK. MUSLEM, S.Ud', 'member', 'Anggota I', '2024 - 2029', 2, 1, NOW(), NOW()),
(@pos_listrik, 'TGK. LUTFI, S.FU', 'member', 'Anggota II', '2024 - 2029', 3, 1, NOW(), NOW());

-- 15. BAGIAN INVENTARIS (Division)
INSERT INTO structure_positions (institution_id, category, position_name, sort_order, is_pinned, is_active, created_at, updated_at)
VALUES (@dayah_id, 'division', 'Bagian Inventaris', 14, 0, 1, NOW(), NOW());
SET @pos_inventaris = LAST_INSERT_ID();

INSERT INTO structure_members (position_id, name, member_role, title, period, sort_order, is_active, created_at, updated_at) VALUES
(@pos_inventaris, 'TGK. ISRAHUDDIN, S.PdI', 'head', 'Ketua / Pengelola', '2024 - 2029', 1, 1, NOW(), NOW());

-- 16. BAGIAN IBADAH (Division)
INSERT INTO structure_positions (institution_id, category, position_name, sort_order, is_pinned, is_active, created_at, updated_at)
VALUES (@dayah_id, 'division', 'Bagian Ibadah', 15, 0, 1, NOW(), NOW());
SET @pos_ibadah = LAST_INSERT_ID();

INSERT INTO structure_members (position_id, name, member_role, title, period, sort_order, is_active, created_at, updated_at) VALUES
(@pos_ibadah, 'TGK. RIDWAN, S.Ag', 'head', 'Ketua', '2024 - 2029', 1, 1, NOW(), NOW()),
(@pos_ibadah, 'TGK. MAULANA, S.Ag', 'member', 'Anggota I', '2024 - 2029', 2, 1, NOW(), NOW()),
(@pos_ibadah, 'TGK. M. LUTFI, S.FU', 'member', 'Anggota II', '2024 - 2029', 3, 1, NOW(), NOW()),
(@pos_ibadah, 'TGK. M. NUR, S.Ag', 'member', 'Anggota III', '2024 - 2029', 4, 1, NOW(), NOW());

-- 17. BAGIAN KEBERSIHAN (Division)
INSERT INTO structure_positions (institution_id, category, position_name, sort_order, is_pinned, is_active, created_at, updated_at)
VALUES (@dayah_id, 'division', 'Bagian Kebersihan', 16, 0, 1, NOW(), NOW());
SET @pos_kebersihan = LAST_INSERT_ID();

INSERT INTO structure_members (position_id, name, member_role, title, period, sort_order, is_active, created_at, updated_at) VALUES
(@pos_kebersihan, 'TGK. ISRAHUDDIN, S.PdI', 'head', 'Ketua', '2024 - 2029', 1, 1, NOW(), NOW()),
(@pos_kebersihan, 'TGK. MAULANA, S.Ag', 'member', 'Anggota I', '2024 - 2029', 2, 1, NOW(), NOW()),
(@pos_kebersihan, 'TGK. KHAIRIZAL, S.FU', 'member', 'Anggota II', '2024 - 2029', 3, 1, NOW(), NOW());

-- 18. BAGIAN HUMAS & PERIZINAN (Division)
INSERT INTO structure_positions (institution_id, category, position_name, sort_order, is_pinned, is_active, created_at, updated_at)
VALUES (@dayah_id, 'division', 'Bagian Humas & Perizinan', 17, 0, 1, NOW(), NOW());
SET @pos_humas = LAST_INSERT_ID();

INSERT INTO structure_members (position_id, name, member_role, title, period, sort_order, is_active, created_at, updated_at) VALUES
(@pos_humas, 'TGK. M. NUR, S.Ag', 'head', 'Ketua', '2024 - 2029', 1, 1, NOW(), NOW()),
(@pos_humas, 'TGK. RIDWAN, S.Ag', 'member', 'Anggota I', '2024 - 2029', 2, 1, NOW(), NOW()),
(@pos_humas, 'TGK. KHAIRIZAL, S.FU', 'member', 'Anggota II', '2024 - 2029', 3, 1, NOW(), NOW());
