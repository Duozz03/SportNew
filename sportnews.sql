-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th12 13, 2025 lúc 08:15 AM
-- Phiên bản máy phục vụ: 9.1.0
-- Phiên bản PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `sportnews`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '123456', '2025-12-11 22:10:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `short_description` text,
  `content` longtext,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `articles`
--

INSERT INTO `articles` (`id`, `category_id`, `title`, `thumbnail`, `short_description`, `content`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 'MU thắng Liverpool 2-1', 'thumb_693cae2c74889.jpg', 'MU thắng Liverpool 2-1 trong trận cầu tâm điểm. Messi thua đậm naruto', 'Nội dung chi tiết bài viết MU vs Liverpool...', '2025-12-10 21:50:57', '2025-12-13 07:07:08', 1),
(2, 2, 'Lakers thắng nghẹt thở Warriors', NULL, 'Lakers có chiến thắng kịch tính trước Warriors.', 'Nội dung chi tiết trận Lakers vs Warriors...', '2025-12-10 21:50:57', '2025-12-10 21:50:57', 1),
(3, 3, 'Nadal trở lại ấn tượng', NULL, 'Nadal trở lại sau chấn thương với chiến thắng ấn tượng.', 'Nội dung chi tiết về trận đấu của Nadal...', '2025-12-10 21:50:57', '2025-12-10 21:50:57', 1),
(5, 1, 'Derby nghẹt thở: bàn thắng muộn và bài học phòng ngự', 'thumb_693cae521f500.jpg', 'Trận derby được định đoạt ở cuối trận khi hai đội thay đổi cách tiếp cận trong hiệp hai.', 'Trận derby luôn mang đến áp lực khác biệt: nhịp độ cao, va chạm nhiều và sai lầm bị trừng phạt ngay lập tức.\r\n\r\nHiệp một chứng kiến hai đội chọn lối đá an toàn, ưu tiên khối phòng ngự trung bình và chờ thời cơ từ phản công. Khi đối thủ dâng cao, khoảng trống phía sau hậu vệ biên trở thành mục tiêu khai thác quen thuộc.\r\n\r\nBước sang hiệp hai, nhịp pressing tăng mạnh. Đội chủ nhà đưa thêm một tiền vệ cơ động vào half-space để tạo tam giác phối hợp ở biên, kéo giãn cấu trúc phòng ngự. Những pha đổi cánh nhanh giúp họ tạo ra chuỗi cơ hội liên tiếp.\r\n\r\nBàn thắng quyết định đến muộn nhưng không bất ngờ: nó là kết quả của áp lực liên tục, những quả tạt có chủ đích vào cột hai và khả năng chiếm lĩnh bóng hai. Ở giai đoạn cuối, yếu tố “quản trị trận đấu” – giữ nhịp, giữ vị trí và hạn chế mất bóng – đã tạo khác biệt.\r\n\r\nChiến thắng này nhắc lại một chân lý: trong các trận lớn, đội mắc ít sai lầm hơn thường là đội bước ra với 3 điểm.', '2025-12-12 15:52:01', '2025-12-13 07:07:46', 1),
(6, 1, 'Cuộc đua vô địch: lịch thi đấu dày đặc và bài toán xoay tua', 'thumb_1_2.jpg', 'Giai đoạn then chốt buộc các đội phải cân bằng giữa hiệu suất, thể lực và rủi ro chấn thương.', 'Khi mùa giải bước vào giai đoạn cuối, cuộc đua vô địch thường được quyết định bởi chiều sâu đội hình và năng lực xoay tua.\n\nLịch thi đấu dày đặc khiến mức tải của cầu thủ tăng vọt. Các đội có xu hướng giảm cường độ pressing toàn trận, chuyển sang pressing theo “đợt”, tập trung vào các thời điểm cụ thể để đoạt bóng và phản công nhanh.\n\nVề chiến thuật, nhiều HLV ưu tiên kiểm soát khu vực trung lộ và hạn chế chuyển trạng thái của đối thủ. Trong khi đó, các tình huống cố định lại trở nên quan trọng hơn vì tỷ lệ tạo bàn từ bóng chết tăng rõ khi thể lực suy giảm.\n\nNếu nhìn sâu hơn, khác biệt nằm ở cách các đội quản trị rủi ro: lựa chọn thời điểm mạo hiểm dâng cao, giữ cự ly đội hình, và quan trọng nhất là tránh những pha mất bóng nguy hiểm ở “zone 14”.\n\nTrong cuộc đua đường dài, bản lĩnh không chỉ là thắng trận lớn, mà là biết thắng những trận nhỏ bằng sự ổn định.', '2025-12-12 15:59:01', '2025-12-12 15:59:01', 1),
(7, 1, 'Sơ đồ 3 trung vệ lên ngôi: vì sao nhiều đội chuyển đổi?', 'thumb_1_3.jpg', '3 trung vệ giúp che khoảng trống, tăng quân số ở trung lộ và linh hoạt khi chuyển trạng thái.', 'Sơ đồ 3 trung vệ đang được sử dụng nhiều hơn vì tính linh hoạt cao trong cả phòng ngự lẫn tấn công.\n\nTrong phòng ngự, hệ thống này tạo ra lớp bọc tốt hơn khi đối thủ đánh vào khoảng trống sau lưng hậu vệ biên. Hai wing-back có thể lùi sâu tạo thành hàng thủ 5 người, giảm rủi ro bị khoét ở biên.\n\nTrong tấn công, một trung vệ có thể dâng lên như “playmaker” để kéo người, trong khi wing-back giữ bề rộng. Điều này giúp đội bóng triển khai bóng an toàn và có thêm người ở trung lộ để nhận bóng giữa các tuyến.\n\nTuy nhiên, 3 trung vệ không phải “thuốc tiên”. Nếu wing-back không đủ thể lực, hoặc tuyến giữa thiếu người đánh chặn, đội bóng sẽ bị khai thác khoảng trống trước mặt hàng thủ. Vì vậy, lựa chọn hệ thống cần dựa trên nhân sự và đối thủ cụ thể.\n\nĐiểm mạnh nhất của 3 trung vệ là khả năng chuyển đổi nhanh giữa các trạng thái – và đây là yêu cầu cốt lõi của bóng đá hiện đại.', '2025-12-12 16:06:01', '2025-12-12 16:06:01', 1),
(8, 2, 'Lakers thắng kịch tính: chìa khóa ở rebound và turnover', 'thumb_2_4.jpg', 'Kiểm soát rebound và hạn chế mất bóng giúp Lakers duy trì lợi thế ở hiệp 4.', 'Ở NBA, chênh lệch thường đến từ những thông số “khó thấy” như rebound tấn công và turnover.\n\nTrong trận đấu này, Lakers ưu tiên kiểm soát bảng rổ. Khi họ hạn chế second-chance point của đối thủ, nhịp độ trận đấu giảm và các tình huống set-play trở nên quan trọng hơn.\n\nỞ nửa sân tấn công, Lakers đánh vào mismatch bằng post-up và các pha cắt rổ sau lưng hàng thủ. Khi đối thủ co cụm, bóng được đẩy ra perimeter cho các cú ném trống.\n\nHiệp 4 là nơi bản lĩnh thể hiện: Lakers giảm tempo, tập trung vào những tình huống chất lượng cao và siết chặt phòng ngự 1-1. Đối thủ có chuỗi turnover đúng lúc khiến mọi nỗ lực bám đuổi bị phá vỡ.\n\nThông điệp rõ ràng: muốn thắng đều, bạn phải thắng ở những chi tiết nhỏ, không chỉ ở highlight.', '2025-12-12 16:13:01', '2025-12-12 16:13:01', 1),
(9, 2, 'Phòng ngự zone hay man-to-man: lựa chọn tối ưu tùy đối thủ', 'thumb_2_5.jpg', 'Zone che điểm yếu cá nhân; man-to-man tạo áp lực. Hybrid là xu hướng được ưa chuộng.', 'Zone defense hữu ích khi đội bóng cần bảo vệ khu vực dưới rổ và giảm áp lực phòng ngự 1-1. Tuy nhiên, zone dễ bị phá bởi các đội chuyền bóng nhanh và ném xa ổn định.\n\nMan-to-man tạo áp lực trực tiếp lên người cầm bóng, nhưng đòi hỏi giao tiếp phòng ngự tốt và thể lực cao. Khi gặp những cầu thủ tạo đột biến, man-to-man cần hỗ trợ đúng thời điểm để tránh bị “bẻ gãy” bởi isolation.\n\nVì vậy, nhiều đội lựa chọn hybrid: man-to-man ở phần lớn thời gian, chuyển zone ở cuối pha bóng để làm rối nhịp. Mục tiêu là buộc đối thủ ra quyết định trong thời gian ngắn, giảm chất lượng cú ném.\n\nBất kể hệ thống nào, kỷ luật phòng ngự (close-out, box-out, rotation) mới là yếu tố quyết định.', '2025-12-12 16:20:01', '2025-12-12 16:20:01', 1),
(10, 2, 'Ngôi sao nổ súng: vì sao spacing quyết định hiệu suất ném 3?', 'thumb_2_6.jpg', 'Spacing tốt tạo ra cú ném trống, giảm áp lực và tăng hiệu suất ném xa một cách bền vững.', 'Khi nói về ném 3, nhiều người chỉ nhìn vào kỹ năng cá nhân. Nhưng thực tế, spacing (giãn đội hình) quyết định phần lớn chất lượng cú ném.\n\nMột hệ thống spacing tốt kéo hậu vệ ra khỏi khu vực paint, mở đường cho drive và kick. Khi hậu vệ phải “help” từ góc, cú ném corner 3 thường xuất hiện – đây là cú ném hiệu quả nhất vì khoảng cách ngắn hơn.\n\nCác đội hiện đại ưu tiên đặt hai shooter ở hai góc, một shooter ở cánh, và một big man biết screen tốt. Nhờ vậy, pick-and-roll tạo ra chuỗi lựa chọn: lên rổ, mid-range, hoặc kick ra ngoài.\n\nNếu spacing kém, hậu vệ có thể thu hẹp khoảng trống, ép người cầm bóng vào tình huống khó. Vì vậy, hiệu suất ném 3 bền vững luôn gắn với hệ thống, không chỉ ngôi sao.', '2025-12-12 16:27:01', '2025-12-12 16:27:01', 1),
(11, 3, 'Nadal trở lại ấn tượng: bản lĩnh trong điểm số quan trọng', 'thumb_3_7.jpg', 'Kinh nghiệm và khả năng đọc trận giúp Nadal chiếm lợi thế ở những game then chốt.', 'Sự trở lại của Nadal luôn kéo theo kỳ vọng lớn. Nhưng điều làm anh đặc biệt không chỉ là cú đánh nặng, mà là cách anh “đọc” trận đấu.\n\nTrong những điểm số quan trọng, Nadal thường chọn phương án an toàn nhưng gây áp lực: kéo dài rally, đẩy bóng sâu và buộc đối thủ đánh thêm một cú nữa. Khi đối thủ nóng vội, sai lầm xuất hiện như hệ quả.\n\nMột yếu tố khác là quản trị thể lực. Nadal lựa chọn thời điểm tăng tốc hợp lý, không “đốt” năng lượng quá sớm. Điều này giúp anh giữ được chất lượng di chuyển ở cuối set.\n\nNếu duy trì được thể trạng, Nadal vẫn là đối thủ cực khó chịu bởi anh thắng bằng tâm lý và kỷ luật, không chỉ bằng sức mạnh.', '2025-12-12 16:34:01', '2025-12-12 16:34:01', 1),
(12, 3, 'Trận đấu kéo dài 3 set: cách các tay vợt quản trị rủi ro', 'thumb_3_8.jpg', 'Từ serve đến return, mọi quyết định đều xoay quanh việc giảm sai lầm và tăng hiệu quả điểm số.', 'Tennis 3 set là cuộc chiến của quản trị rủi ro. Mỗi cú mạo hiểm đều phải có lý do và đúng thời điểm.\n\nServe giúp tay vợt giành điểm nhanh, nhưng nếu phụ thuộc quá nhiều vào ace, họ dễ gặp khó khi tỷ lệ giao bóng 1 giảm. Return tốt lại giúp phá nhịp, tạo cơ hội bẻ game dù đối thủ giao bóng mạnh.\n\nỞ các set quyết định, tâm lý đóng vai trò lớn. Tay vợt bản lĩnh thường chọn phương án “cao xác suất”: đẩy bóng sâu, đánh vào điểm yếu và chờ sai lầm, thay vì cố kết thúc nhanh.\n\nĐó là lý do nhiều trận đấu hay nhất không có quá nhiều highlight, nhưng lại giàu tính chiến thuật và kiểm soát.', '2025-12-12 16:41:01', '2025-12-12 16:41:01', 1),
(13, 4, 'Esports chuyên nghiệp: luyện tập, phân tích và sức bền tâm lý', 'thumb_4_9.jpg', 'Đằng sau chiến thắng là lịch tập nghiêm ngặt, review VOD và chuẩn bị tâm lý thi đấu.', 'Esports ở cấp độ chuyên nghiệp là một hệ thống vận hành bài bản. Tuyển thủ không chỉ luyện kỹ năng cá nhân mà còn phải tuân thủ lịch scrim, review VOD và phân tích đối thủ.\n\nKỹ năng “macro” – kiểm soát mục tiêu, nhịp độ, tầm nhìn – thường quyết định kết quả hơn là những pha xử lý cá nhân. Đội mạnh luôn biết khi nào giao tranh, khi nào tránh, và khi nào đổi mục tiêu để tối ưu lợi thế.\n\nNgoài ra, yếu tố tâm lý cực quan trọng. Một ván thua có thể kéo theo hiệu ứng domino nếu đội thiếu người dẫn dắt tinh thần. Vì vậy, nhiều đội đầu tư chuyên gia tâm lý và quy trình hồi phục sau trận.\n\nEsports đang ngày càng giống thể thao truyền thống: cạnh tranh khốc liệt, chuyên nghiệp hóa và đòi hỏi kỷ luật cao.', '2025-12-12 16:48:01', '2025-12-12 16:48:01', 1),
(14, 4, 'Meta thay đổi liên tục: đội mạnh thích nghi nhanh như thế nào?', 'thumb_693cadd48bc84.jpg', 'Khả năng đọc meta và triển khai chiến thuật mới quyết định việc đội tuyển duy trì phong độ dài hạn.', 'Patch thay đổi khiến meta biến động liên tục. Đội tuyển mạnh không chỉ phản ứng nhanh mà còn chủ động “định hình” meta bằng chiến thuật mới.\r\n\r\nQuy trình thường bắt đầu từ phân tích patch: tướng/đội hình nào mạnh, nhịp độ trận đấu nhanh hay chậm, và điều kiện thắng (win condition) là gì. Sau đó đội thử nghiệm trong scrim, chốt bộ chiến thuật ưu tiên.\r\n\r\nKhác biệt nằm ở tốc độ ra quyết định. Đội có hệ thống phân tích tốt sẽ rút ngắn thời gian thử sai, tránh lãng phí buổi tập. Khi vào giải, họ có thể chuẩn bị nhiều phương án cấm/chọn và xoay chuyển theo đối thủ.\r\n\r\nTrong esports, thích nghi nhanh đôi khi quan trọng hơn cả kỹ năng cá nhân.', '2025-12-12 16:55:01', '2025-12-13 07:05:40', 1),
(15, 5, 'Bóng chuyền: màn ngược dòng nhờ chắn lưới và phát bóng chiến thuật', 'thumb_693cad401c9dc.jpg', 'Khả năng phát bóng gây khó và tổ chức chắn lưới tốt giúp đội bóng lật ngược thế trận.', 'Trong bóng chuyền, phát bóng và chắn lưới là hai yếu tố có thể thay đổi cục diện nhanh nhất.\r\n\r\nKhi đội bóng chuyển sang phát bóng chiến thuật nhắm vào vị trí chuyền hai hoặc chủ công đang xuống sức, hệ thống tấn công của đối thủ bị phá vỡ. Bóng một kém khiến họ phải xử lý trong điều kiện bất lợi, giảm chất lượng đập bóng.\r\n\r\nỞ chiều ngược lại, tổ chức chắn lưới theo “đọc bóng” (read block) giúp đội phòng ngự tăng tỷ lệ chạm chắn và tạo cơ hội phản công. Những tình huống bóng bật chắn rơi vào khu vực trống thường mang lại điểm số quan trọng.\r\n\r\nTrận đấu cho thấy: sự kiên nhẫn và điều chỉnh đúng thời điểm mới là chìa khóa để lội ngược dòng.', '2025-12-12 17:02:01', '2025-12-13 07:03:12', 1),
(16, 5, 'Kỹ thuật chuyền một: nền tảng để tấn công đa dạng trong bóng chuyền', 'thumb_693cacd64b878.jpg', 'Chuyền một tốt giúp chuyền hai có nhiều phương án, từ đó làm hàng chắn đối thủ bị động.', 'Chuyền một là nền móng của bóng chuyền hiện đại. Khi chuyền một ổn định, đội bóng có thể triển khai tấn công nhanh, tấn công biên và cả các bài phối hợp trung lộ.\r\n\r\nNgược lại, chuyền một kém khiến chuyền hai phải “chạy” bóng, đẩy bóng cao ra biên, làm đối thủ dễ bố trí chắn đôi. Vì vậy, chất lượng chuyền một quyết định trực tiếp đến hiệu suất ghi điểm.\r\n\r\nCác đội mạnh thường có hệ thống đỡ bước một kỷ luật: phân vùng rõ ràng, giao tiếp tốt và sẵn sàng hy sinh. Đây là kỹ năng khó thấy trên highlight nhưng quyết định thành bại.', '2025-12-12 17:09:01', '2025-12-13 07:01:26', 1),
(17, 6, 'F1: chiến thuật pit stop và cuộc đua của từng phần mười giây', 'thumb_693cae0a0ecfd.jpg', 'Chỉ vài giây ở pit có thể thay đổi thứ hạng. Quyết định lốp và thời điểm vào pit là tối quan trọng.', 'Trong F1, chiến thắng không chỉ đến từ tốc độ trên đường đua mà còn từ chiến thuật pit stop.\r\n\r\nMột quyết định vào pit sớm có thể tạo lợi thế undercut nếu xe chạy ở không khí sạch. Ngược lại, vào pit muộn hơn (overcut) đôi khi hiệu quả khi đối thủ gặp traffic hoặc lốp mới chưa đạt nhiệt độ tối ưu.\r\n\r\nViệc chọn bộ lốp phụ thuộc vào nhiệt độ mặt đường, mức độ mài mòn và khả năng quản lý lốp của tay đua. Đội đua giỏi sẽ dự báo biến số và chuẩn bị nhiều kịch bản, thay vì bám cứng một phương án.\r\n\r\nTừng phần mười giây tích lũy qua mỗi vòng đua, và sai lầm nhỏ ở pit có thể xóa sạch nỗ lực cả chặng.', '2025-12-12 17:16:01', '2025-12-13 07:06:34', 1),
(18, 6, 'F1: vì sao quản lý lốp quyết định tốc độ đường dài?', 'thumb_693cac7496712.jpg', 'Tốc độ một vòng nhanh chưa đủ; duy trì hiệu suất lốp ổn định mới giúp tay đua bứt phá.', 'Quản lý lốp là nghệ thuật của F1. Một tay đua có thể chạy rất nhanh trong 1 vòng, nhưng nếu lốp xuống cấp sớm, họ sẽ mất thời gian lớn ở chặng sau.\r\n\r\nCác yếu tố ảnh hưởng gồm: phong cách phanh, cách vào cua, nhiệt độ lốp và mức độ trượt bánh. Đội đua thường điều chỉnh setup (góc camber, độ cứng hệ thống treo) để tối ưu cho từng loại lốp và đường đua.\r\n\r\nKhi lốp được giữ trong “cửa sổ nhiệt độ” lý tưởng, xe ổn định và có thể tấn công. Nếu vượt quá, lốp sẽ mòn nhanh, làm giảm tốc độ đáng kể.\r\n\r\nĐây là lý do nhiều chặng đua được quyết định bởi nhịp độ ổn định, không chỉ khoảnh khắc vượt xe.', '2025-12-12 17:23:01', '2025-12-13 06:59:48', 1),
(19, 7, 'Cầu lông: chiến thuật điều cầu và kiểm soát nhịp độ trận đấu', 'thumb_693cad0db2b60.jpg', 'Điều cầu sâu – cắt lưới – đổi hướng liên tục giúp tay vợt tạo lợi thế bền vững.', 'Cầu lông không chỉ là tốc độ, mà là kiểm soát nhịp độ bằng điều cầu.\r\n\r\nKhi tay vợt đánh cầu sâu về cuối sân, đối thủ buộc phải lùi, mở ra khoảng trống phía trước để cắt lưới. Việc đổi hướng liên tục khiến đối thủ di chuyển nhiều, tiêu hao thể lực và giảm chất lượng phản xạ.\r\n\r\nỞ các điểm số quan trọng, tay vợt bản lĩnh thường chọn phương án an toàn: kéo dài pha cầu, buộc đối thủ đánh thêm một nhịp thay vì mạo hiểm dứt điểm sớm.\r\n\r\nChiến thắng vì thế thường đến từ sự kiên nhẫn và kỷ luật chiến thuật.', '2025-12-12 17:30:01', '2025-12-13 07:02:21', 1),
(20, 7, 'Cầu lông đôi: phối hợp vị trí và vai trò tấn công/phòng thủ', 'thumb_693ca73e2e860.jpg', 'Trong đánh đôi, sự ăn ý và chia khu vực chuẩn giúp hạn chế sai lầm và tạo cơ hội kết thúc.', 'Đánh đôi cầu lông đòi hỏi phối hợp vị trí cực tốt. Khi tấn công, cặp đôi thường bố trí trước–sau để khai thác cầu đập và chặn lưới. Khi phòng thủ, họ chuyển sang trái–phải để che kín sân.\r\n\r\nSai lầm phổ biến là dẫm chân nhau hoặc bỏ trống khu vực giữa sân. Vì vậy, giao tiếp và hiểu vai trò từng người là điều bắt buộc.\r\n\r\nMột cặp đôi mạnh thường có người kiểm soát lưới tốt và người có sức đập mạnh ở cuối sân. Sự cân bằng này giúp họ chuyển trạng thái linh hoạt và kết thúc điểm số hiệu quả.', '2025-12-12 17:37:01', '2025-12-13 06:37:34', 1),
(21, 8, 'Võ thuật: chiến thắng bằng chiến thuật, không chỉ sức mạnh', 'thumb_693cac157fe1e.jpg', 'Nhịp độ, khoảng cách và thời điểm ra đòn là các yếu tố then chốt giúp võ sĩ kiểm soát trận đấu.', 'Trong võ thuật đối kháng, sức mạnh quan trọng nhưng không đủ. Người thắng thường là người kiểm soát khoảng cách và nhịp độ tốt hơn.\r\n\r\nVõ sĩ khôn ngoan sẽ dùng feint để “mở” phản xạ đối thủ, sau đó phản công đúng thời điểm. Họ không lao vào trao đổi vô tội vạ mà chọn điểm rơi: lúc đối thủ hụt đòn hoặc mất thăng bằng.\r\n\r\nMột yếu tố khác là quản trị thể lực. Nếu đẩy nhịp quá sớm, võ sĩ dễ xuống sức ở hiệp cuối. Do đó, chiến thuật tăng tốc theo từng hiệp giúp họ duy trì sự sắc bén.\r\n\r\nChiến thắng bền vững luôn gắn với kỷ luật và tính toán, không chỉ sự liều lĩnh.', '2025-12-12 17:44:01', '2025-12-13 06:58:13', 1),
(22, 8, 'MMA: vì sao grappling quyết định nhiều trận đấu lớn?', 'thumb_693c468965820.jpg', 'Khả năng vật và kiểm soát sàn giúp võ sĩ chuyển hóa lợi thế, hạn chế rủi ro từ đòn đánh đứng.', 'Trong MMA, grappling (vật, khóa siết, kiểm soát sàn) là mảnh ghép quyết định của nhiều trận đấu.\r\n\r\nMột võ sĩ đánh đứng hay nhưng phòng thủ takedown kém sẽ bị kéo vào “vùng nguy hiểm”: bị ép lồng sắt, bị quật ngã và phải chống đỡ trong thế bị động. Khi đó, họ tốn thể lực lớn để đứng dậy.\r\n\r\nNgược lại, võ sĩ có grappling tốt có thể kiểm soát nhịp trận: đưa đối thủ xuống sàn, giữ vị trí, tích điểm và tìm cơ hội khóa siết. Đây là cách thắng an toàn và ít rủi ro hơn so với trao đổi đòn liên tục.\r\n\r\nVì vậy, ở trình độ cao, grappling thường là yếu tố phân định đẳng cấp.', '2025-12-12 17:51:01', '2025-12-12 23:44:57', 1),
(28, 1, 'Lịch thi đấu Việt Nam', 'thumb_693cabaf11646.jpg', 'Nhật Bản - Việt Nam', 'Một trận đấu hay', '2025-12-13 06:56:31', '2025-12-13 07:00:02', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`) VALUES
(1, 'Bóng đá nam', 'bong-da', '2025-12-10 21:50:44'),
(2, 'Bóng rổ', 'bong-ro', '2025-12-10 21:50:44'),
(3, 'Tennis', 'tennis', '2025-12-10 21:50:44'),
(4, 'Esports', 'esports', '2025-12-10 21:50:44'),
(5, 'Bóng chuyền', 'bong-chuyen', '2025-12-12 07:32:01'),
(6, 'Đua xe F1', 'dua-xe-f1', '2025-12-12 07:32:01'),
(7, 'Cầu lông', 'cau-long', '2025-12-12 07:32:01'),
(8, 'Võ thuật', 'vo-thuat', '2025-12-12 07:32:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `article_id` int NOT NULL,
  `author_name` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `rating` tinyint NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_comments_article` (`article_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `article_id`, `author_name`, `content`, `rating`, `created_at`, `status`) VALUES
(1, 1, 'abc', 'Hay', 5, '2025-12-12 10:07:17', 1),
(2, 1, 'eee', 'tệ', 4, '2025-12-12 10:07:27', 1),
(3, 22, 'Nguyễn Văn A', 'Hay', 5, '2025-12-13 08:16:07', 1),
(4, 22, 'Nguyễn Văn B', 'sadgasdaskj', 4, '2025-12-13 10:02:58', 1),
(5, 22, 'Nguyễn Văn C', 'hay', 4, '2025-12-13 10:12:43', 1),
(6, 28, 'Nguyễn Văn A', 'aadsa', 5, '2025-12-13 10:19:56', 1),
(7, 28, 'B', 'adsadas', 4, '2025-12-13 10:36:03', 1),
(8, 28, 'Nguyễn Van E', 'aadsad', 5, '2025-12-13 10:51:08', 1),
(9, 22, 'eee', 'ads', 5, '2025-12-13 11:02:04', 1);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
